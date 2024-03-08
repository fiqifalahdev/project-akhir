<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eloquent code
        DB::table('wilayah_2022')
            ->where(DB::raw('LENGTH(kode)'), '=', 2)
            ->select(DB::raw('LEFT(kode, 2) as id'), 'nama as name')
            ->orderBy('kode')
            ->chunk(200, function ($results) {
                foreach ($results as $result) {
                    Province::updateOrCreate(
                        ['id' => $result->id],
                        ['name' => $result->name]
                    );
                }
            });
    }
}
