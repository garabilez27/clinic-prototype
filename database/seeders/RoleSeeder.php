<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_roles')->insert([
            [
                'rl_id' => 'RL00001',
                'rl_detail' => 'Developer',
            ],
            [
                'rl_id' => 'RL00002',
                'rl_detail' => 'Admin',
            ],
        ]);
    }
}
