<?php

namespace Database\Seeders;

use App\Models\Village;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillageSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eloquent code
        DB::table('wilayah_2022')
            ->where(DB::raw('LENGTH(kode)'), '=', 13)
            ->select(
                DB::raw('CONCAT(CONCAT(CONCAT(LEFT(kode, 2), RIGHT(LEFT(kode, 5), 2)), RIGHT(LEFT(kode, 8), 2)), RIGHT(LEFT(kode, 13), 4)) as id'),
                DB::raw('CONCAT(CONCAT(LEFT(kode, 2), RIGHT(LEFT(kode, 5), 2)), RIGHT(LEFT(kode, 8), 2)) as district_id'),
                'nama as name'
            )
            ->orderBy('kode')
            ->chunk(200, function ($results) {
                foreach ($results as $result) {
                    Village::updateOrCreate(
                        ['id' => $result->id],
                        [
                            'district_id' => $result->district_id,
                            'name' => $result->name
                        ]
                    );
                }
            });
    }
}
