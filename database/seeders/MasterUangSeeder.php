<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterUangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            [
                'id' => '1',
                'master_uang' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('master_uangs')->insert($data);
    }
}
