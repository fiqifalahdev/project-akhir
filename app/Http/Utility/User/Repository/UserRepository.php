<?php

namespace App\Http\Utility\User\Repository;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Traits\UploadFile;

class UserRepository
{
    use UploadFile;
    // =============== Select Data ===============
    /**
     * Get Base Info User
     * @return User
     * 
     */
    public function getBaseInfoByUserId(int $user_id): User
    {
        return User::find($user_id);
    }

    // =============== Insert, Update, Delete Data ===============

    /**
     * Update User Data
     * @return User
     */
    public function updateUserData(array $data, User $user): bool
    {
        // Cek apakah location user sudah terisi atau belum
        // jika belum maka insert ketika update data user baru
        // jika sudah maka update data user
        // $location = $user->location();

        // DB::beginTransaction();

        // if ($location->get()->isEmpty()) {
        //     $location->create([
        //         'name' => $data['name'],
        //         'address' => $data['address'],
        //         'longitude' => $data['longitude'],
        //         'latitude' => $data['latitude'],
        //         'kel_id' => $data['kel_id'],
        //         'user_id' => $user->id,
        //     ]);
        // } else {
        //     $location->update([
        //         'name' => $data['name'],
        //         'address' => $data['address'],
        //         'longitude' => $data['longitude'],
        //         'latitude' => $data['latitude'],
        //         'kel_id' => $data['kel_id'],
        //         'user_id' => $user->id,
        //     ]);
        // }

        // Make Upload Image
        // dd($data['profile_image']->getFileName());

        // Update User Data
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'birthdate' => $data['birthdate'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'role' => $data['role'],
            'profile_image' => $data['profile_image_path'],
        ]);

        // DB::commit();

        return true;
    }
}
