<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\FishMarket;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // User::factory()->count(4)->create();

        // Location::newFactory()->count(4)->create();

        // FishMarket::factory()->count(10)->create();

        // $this->call([
        //     ProvinceSeed::class,
        //     RegencySeed::class,
        //     DistrictSeed::class,
        //     VillageSeed::class,
        // ]);


        User::create([
            'id' => 1,
            'name' => 'Ahmad Fathoni',
            'email' => 'fathoni29@gmail.com',
            'phone' => '085606195220',
            'birthdate' => '1985-12-29',
            'gender' => 'Laki-Laki',
            'address' => 'Sekardangan Blok E-1',
            'role' => 'pembudidaya',
            'password' => 'fathoni123',
        ]);

        User::create([
            'id' => 2,
            'name' => 'Jiyanto',
            'email' => 'jiyanto@gmail.com',
            'phone' => '081553701179',
            'birthdate' => '1980-08-10', // generate random
            'gender' => 'Laki-Laki',
            'address' => 'Urangagung RT 12 RW 03',
            'role' => 'pembudidaya',
            'password' => 'jiyantoi123',
        ]);

        User::create([
            'id' => 3,
            'name' => 'Ahmad Fakhrin Niam',
            'email' => 'fakhirnniam@gmail.com',
            'phone' => '081357692029',
            'birthdate' => '2002-10-28',
            'gender' => 'Laki-Laki',
            'address' => 'Kedungpeluk RT 01 RW 01',
            'role' => 'pengepul',
            'password' => 'fakhrini123',
        ]);

        User::create([
            'id' => 4,
            'name' => 'Mbah No',
            'email' => 'mbahnofihery1@gmail.com',
            'phone' => '085606195220',
            'birthdate' => '1985-12-29',
            'gender' => 'Laki-Laki',
            'address' => 'Sekardangan Blok E-1',
            'role' => 'pengepul',
            'password' => 'mbahnoi123',
        ]);


        Location::create([
            'address' => 'Tambak, Gebang, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur',
            'latitude' => '-7.473455310995684',
            'longitude' => '112.75599480885847',
            'user_id' => 1,
        ]);

        Location::create([
            'address' => 'HQ3R+MHC, Sawohan, Kec. Buduran, Kabupaten Sidoarjo, Jawa Timur 61252',
            'latitude' => '-7.444966328790096',
            'longitude' => '112.79395415241356',
            'user_id' => 2,
        ]);

        Location::create([
            'address' => 'GQQ2+CH6, Rangkah Kidul, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61234',
            'latitude' => '-7.461198807322241',
            'longitude' => '112.75133960021704',
            'user_id' => 3,
        ]);

        Location::create([
            'address' => 'Komplek Pergudangan & Industri Safe N Lock Block O No.1768-1769, Jl. Lkr. Timur No.KM 5, RW.5, Rangkah Kidul, Kec. Sidoarjo, Kabupaten Sidoarjo',
            'latitude' => '-7.460287030806034',
            'longitude' => '112.75142914584664',
            'user_id' => 4,
        ]);
    }
}
