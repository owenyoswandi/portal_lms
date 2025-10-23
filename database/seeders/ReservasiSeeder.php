<?php

namespace Database\Seeders;

use App\Models\tbl_reservasi;
use Illuminate\Database\Seeder;

class ReservasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tbl_reservasi::factory()->count(50)->make();
    }
}
