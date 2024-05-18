<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\AppointmentRequest as Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class AppointmentController extends Controller
{

    /**
     *  store appointments
     * 
     * 
     */
    public function store(AppointmentRequest $request)
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
            // $messaging = CloudMessage::withTarget('token', 'token')
            //     ->withNotification([
            //         'title' => 'Janji temu baru',
            //         'body' => 'Anda memiliki janji temu baru'
            //     ]);

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
}
