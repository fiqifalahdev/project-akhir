<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Utility\User\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\UploadFile;

class ProfileController extends Controller
{
    use UploadFile;

    public function __construct(
        private UserService $user_service
    ) {
    }

    /**
     * Display a listing of the resource.
     * or in other word this function is for showing a base_info from user
     */
    public function index()
    {
        try {

            $base_info = $this->user_service->getBaseInfo(auth()->user());

            return response()->json([
                'success' => true,
                'message' => 'User base info : ' . $base_info->name,
                'data' => ['detail' => $base_info, 'location' => $base_info->location()->first()],
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
                'data' => ['detail' => $detail_profile, 'location' => $detail_profile->location()->first()], // nanti tambahkan detail lokasi juga
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, int $user_id)
    {
        try {
            if ($request->hasFile('profile_image')) {
                $path = $this->uploadFile($request->profile_image, 'profileImages', 'public', $request->name . '_profile_img');
            }

            // Automatically validate the incoming request
            // update user profile with send the request data and user data
            $update_profile = $this->user_service->updateProfile([...$request->validated(), 'profile_image_path' => $path], $user_id);

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
     * Remove the specified resource from storage.
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
