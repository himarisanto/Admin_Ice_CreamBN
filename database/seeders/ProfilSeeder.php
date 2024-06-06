<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_lengkap' => 'Admin',
                'job' => 'admin ice cream',
                'wa' => '84683561762',
                'tentang' => 'ini data keterangan untuk user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('profils')->insert($data);
    }
}
