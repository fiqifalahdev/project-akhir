<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\AppointmentRequest as Appointment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{
    public function __construct(protected $messaging = new NotificationController())
    {
    }
    /**
     *  get appointment request by auth user
     * 
     * 
     */
    public function appointmentRequest(): JsonResponse
    {
        try {
            $appointments = Appointment::with('recipient')
                ->where('requester_id', auth()->id())
                ->whereNot('appointment_date', '<', now()->format('Y-m-d'))
                ->orderBy('appointment_time', 'asc')
                ->get();

            if ($appointments->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data janji temu tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data janji temu ditemukan',
                'data' => $appointments,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error : ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get incoming appointment for recipient user 
     * 
     * 
     */
    public function appointmentRecipient(): JsonResponse
    {
        try {
            $appointments = Appointment::with('requester')
                ->where('recipient_id', auth()->id())
                ->where('status', 'pending')
                ->where(function (Builder $query) {
                    return $query->whereNot('appointment_date', '<', now()->format('Y-m-d'));
                })
                ->orderBy('created_at', 'desc')
                ->get();

            if ($appointments->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Janji temu tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data Janji temu',
                'data' => [
                    'appointments' => $appointments,
                    'appointmentSum' => $appointments->count()
                ]
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error : ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     *  store appointment request
     * 
     * 
     */
    public function store(AppointmentRequest $request): JsonResponse
    {
        try {

            $store = Appointment::create([
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'requester_id' => auth()->id(),
                'recipient_id' => $request->recipient_id,
                'status' => 'pending'
            ]);

            // Nanti setelah membuat tambahkan kirim notif ke frontend
            /**
             * Kirim notif nya berupa pesan janji temu baru! 
             * dengan membawa id dari yang diminta
             * 
             */
            $this->messaging->sendNotification("Janji temu baru", "Anda memiliki permintaan janji temu", $request->recipient_id);

            if (!$store) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat janji temu'
                ], Response::HTTP_BAD_REQUEST);
            }

            return response()->json([
                'success' => true,
                'message' => 'Janji temu berhasil dibuat',
                'data' => $store
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error : ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Reject Appoinment Confirmations 
     *  
     * @param string $appointmentId
     * @param bool $status
     * 
     * @return JsonResponse
     * 
     */
    public function updateAppointmentStatus(string $appointmentId, Request $request): JsonResponse
    {
        try {
            $request->validate([
                'status' => 'required|boolean'
            ]);

            // if status was true it means that the appointment was accepted
            if ($request->status) {
                // update status to accepted
                $appointment = Appointment::when($appointmentId, function (Builder $query, $appointmentId) {
                    $query->where('appointment_id', $appointmentId)->update(['status' => 'accepted']);
                    return $query;
                })->first();
                if (!$appointment) {
                    throw new \Exception("Gagal menerima janji temu");
                }

                // Nanti setelah membuat tambahkan kirim notif ke frontend
                $this->messaging->sendNotification("Janji temu diterima", "Permintaan janji temu anda diterima", $appointment->requester->id);

                return response()->json([
                    'success' => true,
                    'message' => 'Menerima Janji temu',
                ], Response::HTTP_OK);
            } else {
                // update status to rejected
                $appointment = Appointment::when($appointmentId, function (Builder $query, $appointmentId) {
                    $query->where('appointment_id', $appointmentId)->update(['status' => 'rejected']);
                    return $query;
                })->first();

                if (!$appointment) {
                    throw new \Exception("Gagal menolak janji temu");
                }

                // Nanti setelah membuat tambahkan kirim notif ke frontend
                $this->messaging->sendNotification("Janji temu ditolak", "Permintaan janji temu anda ditolak", $appointment->requester->id);

                return response()->json([
                    'success' => true,
                    'message' => 'Menolak Janji temu',
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error : ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
