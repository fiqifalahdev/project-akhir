<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eloquent code
        DB::table('wilayah_2022')
            ->where(DB::raw('LENGTH(kode)'), '=', 8)
            ->select(
                DB::raw('CONCAT(CONCAT(LEFT(kode, 2), RIGHT(LEFT(kode, 5), 2)), RIGHT(kode, 2)) as id'),
                DB::raw('CONCAT(LEFT(kode, 2), RIGHT(LEFT(kode, 5), 2)) as regency_id'),
                'nama as name'
            )
            ->orderBy('kode')
            ->chunk(200, function ($results) {
                foreach ($results as $result) {
                    District::updateOrCreate(
                        ['id' => $result->id],
                        [
                            'regency_id' => $result->regency_id,
                            'name' => $result->name
                        ]
                    );
                }
            });
    }
}
