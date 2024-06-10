<?php

namespace App\Http\Utility\User\Services;

use App\Http\Utility\User\Repository\UserRepository;
use App\Models\User;
use Carbon\Carbon;

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
    public function updateProfile(array $requestData)
    {
        try {
            // Get User by its id.
            $user = $this->user_repository->getBaseInfoByUserId(auth()->id());

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

    /**
     * function for find the nearest time
     * 
     * @param array $data
     * @return string
     * 
     */
    public function findNearestTime(object $data)
    {
        // Get the current time
        $now = Carbon::now();

        // Initialize variables to store the nearest time and the smallest difference
        $nearestTime = null;
        $smallestDifference = PHP_INT_MAX;


        // // Loop through each time in the array
        foreach ($data as $time) {
            // Convert the time to a Carbon instance
            $timestamp = Carbon::parse($time->appointment_time);

            // Calculate the absolute difference between the current time and the timestamp
            $difference = $now->diffInSeconds($timestamp, false);

            // If this difference is smaller than the smallest difference found so far
            if (abs($difference) < $smallestDifference) {
                // Update the smallest difference and the nearest time
                $smallestDifference = abs($difference);
                $nearestTime = $time->appointment_time;
            }
        }

        // Return the latest appointment
        return $nearestTime;
    }

    /**
     * function for check the appointment_date comparison
     * 
     * @param DateTime $appointment_date1
     * @param DateTime $appointment_time1
     * 
     * @param DateTime $appointment_date2
     * @param DateTime $appointment_time2
     * 
     * @return bool
     */
    public function checkAppointmentDate($appointment_date1, $appointment_time1, $appointment_date2, $appointment_time2)
    {
        try {
            $date1 = new \DateTime($appointment_date1 . ' ' . $appointment_time1);
            $date2 = new \DateTime($appointment_date2 . ' ' . $appointment_time2);

            if ($date1 < $date2) {
                return true;
            }

            // it means the appointment date is not greater than now
            return false;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
