<?php

namespace App\Http\Controllers;

use App\Jobs\NotificationJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Factory;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{

    protected $messaging;

    public function __construct()
    {
        $this->messaging = app('firebase.messaging');
    }
    /**
     * Check User Device token and store it
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function storeToken(Request $request): JsonResponse
    {
        try {
            $userToken = DB::table('user_device_token_tables')
                ->where('user_id', auth()->id())
                ->get();

            if ($userToken->isEmpty()) {
                DB::table('user_device_token_tables', [
                    'user_id' => auth()->id(),
                    'device_token' => $request->device_token
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Device token berhasil disimpan'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error : ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Send Notification to User
     * @param string $title
     * @param string $body
     * @param int $recipient_id
     * 
     * @return void
     */
    public function sendNotification(string $title, string $body, int $recipient_id): void
    {
        try {
            // get device token from database
            $deviceToken = DB::table('user_device_token_tables')
                ->where('user_id', $recipient_id)
                ->get();

            // Harusnya dikasih Job Disini
            foreach ($deviceToken as $token) {
                NotificationJob::dispatch($token->device_token, $title, $body);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
