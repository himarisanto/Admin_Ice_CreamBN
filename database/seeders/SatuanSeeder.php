<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_satuan' => 'PCS',
                'keterangan' => 'ini satuan untuk pcs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_satuan' => 'boks',
                'keterangan' => 'ini satuan untuk boks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_satuan' => 'unit',
                'keterangan' => 'ini jenis unit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('satuans')->insert($data);

    }
}
