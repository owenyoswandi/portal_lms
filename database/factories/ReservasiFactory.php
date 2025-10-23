<?php

namespace Database\Factories;

use App\Models\tbl_daftarpasien;
use App\Models\tbl_reservasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservasiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = tbl_reservasi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'no_reservasi'      => 'RESERV-' . $this->faker->date('YMD', '2025-01-01') . '-' . rand(0, 100),
            'no_daftarpasien'   => tbl_daftarpasien::select('no_daftar')->inRandomOrder()->skip(rand(0, 10))->first(),
            'tgl_reservasi'     => $this->faker->date(),
            'rujukan'           => 'RS ' . $this->faker->city(),
            'dokter'            => $this->faker->name(),
            'jenis_asuransi'    => $this->faker->randomElements(['umum', 'kontraktor']),
            'nama_asuransi'     => $this->faker->randomElements(['umum', 'bpjs']),
            'poli'              => $this->faker->word(),
            'status'            => 'default',
        ];
    }
}
