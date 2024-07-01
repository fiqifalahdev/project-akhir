<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Utility\User\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\UploadFile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProfileApiController extends Controller
{
    use UploadFile;

    public function __construct(
        private UserService $user_service
    ) {
    }

    /**
     * Show All users that registered on apps
     * 
     * 
     */
    public function getAllUsers()
    {
        try {
            $users = User::with('location')->get();

            foreach ($users as $user) {
                $data[] = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'gender' => $user->gender,
                    'birthdate' => $user->birthdate,
                    'profile_image' => $user->profile_image,
                    'location' => $user->location,
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'All users',
                'data' => $data,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display a listing of the resource.
     * or in other word this function is for showing a base_info from user
     *    - add the catalog image on the detail profile
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {

            $base_info = $this->user_service->getBaseInfo(auth()->user());

            // Retrieve appointment times
            $checkDate = $base_info->appointmentAcceptance()
                ->with('requester')
                ->where('status', 'accepted')
                ->whereNot('appointment_date', '<=', now())
                ->orderBy('appointment_date', 'asc')
                ->first();

            if ($base_info instanceof \Exception) {
                return response()->json([
                    'success' => false,
                    'message' => $base_info->getMessage(),
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'message' => 'User base info : ' . $base_info->name,
                'data' => [
                    'detail' => $base_info,
                    'location' => $base_info->location()->get(),
                    'feeds' => $base_info->feeds()->get(),
                    'appointmentSum' => $base_info->appointmentAcceptance()->where('recipient_id', $base_info->id)->where('status', 'pending')->whereNot('appointment_date', '<', now()->format('Y-m-d'))->count(),
                    'latestAppointment' => $checkDate == null ? null : $checkDate->toArray(),
                ],
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     * Dispay the Detailed Profile of the user
     *    - add the feed image on the detail profile
     * 
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    public function show(int $user_id)
    {
        try {
            // Get Detail profile by its id.
            $detail_profile = $this->user_service->getDetailProfile($user_id);

            if ($detail_profile instanceof \Exception) {
                return response()->json([
                    'success' => false,
                    'message' => $detail_profile->getMessage(),
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'message' => 'User detail profile : ' . $detail_profile->name,
                'data' => ['detail' => $detail_profile, 'location' => $detail_profile->location()->get(), 'feeds' => $detail_profile->feeds()->get()], // nanti tambahkan detail lokasi juga
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Update the user profile.
     * 
     * @param ProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    public function update(ProfileRequest $request)
    {
        try {
            if ($request->hasFile('profile_image')) {
                $path = $this->uploadFile($request->profile_image, 'profileImages', 'public', $request->name . '_profile_img');
            } else {
                $path = null;
            }


            // Automatically validate the incoming request
            // update user profile with send the request data and user data
            $update_profile = $this->user_service->updateProfile([...$request->validated(), 'profile_image_path' => $path]);

            if ($update_profile instanceof \Exception) {
                return response()->json([
                    'success' => false,
                    'message' => $update_profile->getMessage(),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json([
                'success' => true,
                'message' => 'User profile updated!',
                'data' => $update_profile,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove user account 
     * 
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $user_id)
    {
        try {
            $deleteUser = $this->user_service->deleteProfile($user_id);

            if ($deleteUser instanceof \Exception) {
                return response()->json([
                    'success' => false,
                    'message' => $deleteUser->getMessage(),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json([
                'success' => true,
                'message' => 'User profile deleted!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
