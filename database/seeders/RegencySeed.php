<?php

namespace Database\Seeders;

use App\Models\Regency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegencySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eloquent code
        DB::table('wilayah_2022')
            ->where(DB::raw('LENGTH(kode)'), '=', 5)
            ->select(
                DB::raw('CONCAT(LEFT(kode, 2), RIGHT(kode, 2)) as id'),
                DB::raw('LEFT(kode, 2) as province_id'),
                'nama as name'
            )
            ->orderBy('kode')
            ->chunk(200, function ($results) {
                foreach ($results as $result) {
                    Regency::updateOrCreate(
                        ['id' => $result->id],
                        [
                            'province_id' => $result->province_id,
                            'name' => $result->name
                        ]
                    );
                }
            });
    }
}
