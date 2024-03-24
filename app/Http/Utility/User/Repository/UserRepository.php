<?php

namespace App\Http\Utility\User\Repository;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
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
        $location = $user->location();

        DB::beginTransaction();

        if ($location->get()->isEmpty()) {
            $location->create([
                'name' => $data['name'],
                'address' => $data['address'],
                'longitude' => $data['longitude'],
                'latitude' => $data['latitude'],
                'kel_id' => $data['kel_id'],
                'user_id' => $user->id,
            ]);
        } else {
            $location->update([
                'name' => $data['name'],
                'address' => $data['address'],
                'longitude' => $data['longitude'],
                'latitude' => $data['latitude'],
                'kel_id' => $data['kel_id'],
                'user_id' => $user->id,
            ]);
        }

        $user->update($data);

        DB::commit();

        return true;
    }
}
