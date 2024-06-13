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

        FishMarket::factory()->count(10)->create();

        // $this->call([
        //     ProvinceSeed::class,
        //     RegencySeed::class,
        //     DistrictSeed::class,
        //     VillageSeed::class,
        // ]);


    }
}
