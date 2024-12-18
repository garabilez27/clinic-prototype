<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_role_menus')->insert([
            [
                'rl_id' => 'RL00001',
                'mn_id' => 'MN00001',
            ],
            [
                'rl_id' => 'RL00001',
                'mn_id' => 'MN00002',
            ],
            [
                'rl_id' => 'RL00002',
                'mn_id' => 'MN00001',
            ],
        ]);
    }
}
