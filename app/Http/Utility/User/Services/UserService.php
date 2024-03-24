<?php

namespace App\Http\Utility\User\Services;

use App\Http\Utility\User\Repository\UserRepository;
use App\Models\User;

class UserService
{
    public function __construct(
        private UserRepository $user_repository
    ) {
    }


    /**
     * Get Base Info User
     * @return User
     */
    public function getBaseInfo()
    {
        try {
            // Get User by its id.
            $repo = $this->user_repository->getBaseInfoByUserId(auth()->id());

            // Check user is exist
            $response = match ($repo) {
                null => new \Exception('User not found!'),
                default => $repo
            };

            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get Detail Profile User
     * @return User
     */
    public function getDetailProfile(int $user_id)
    {
        try {
            // Get User by its id.
            $repo = $this->user_repository->getBaseInfoByUserId($user_id);

            // Check user is exist
            $response = match ($repo) {
                null => new \Exception('User not found!'),
                default => $repo
            };

            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update Profile User
     * 
     * @param array $requestData
     * @param int $user_id
     * 
     * @return bool
     * @throws \Exception
     * 
     * Mungkin fungsi ini bisa ditambahkan sebuah insert data ke table location.
     * berhubung User memiliki relasi ke Location.
     * 
     */
    public function updateProfile(array $requestData, int $user_id)
    {
        try {
            // Get User by its id.
            $user = $this->user_repository->getBaseInfoByUserId($user_id);

            // Check user is exist
            if ($user === null) {
                return new \Exception('User not found!');
            }

            // Update user data and location data
            $update = $this->user_repository->updateUserData($requestData, $user);

            $response = match ($update) {
                false => new \Exception('Failed to update user data!'),
                true => $update, // pasti true
                default => true // pasti true
            };

            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deleteProfile(int $user_id)
    {
        try {
            $user = $this->user_repository->getBaseInfoByUserId($user_id);

            if ($user === null) {
                return new \Exception('User not found!');
            }

            $delete = $user->delete();

            if ($delete === false) {
                return new \Exception('Failed to delete user data!');
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
