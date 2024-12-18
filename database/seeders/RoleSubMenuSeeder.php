<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_role_sub_menus')->insert([
            [
                'rlmn_id' => '2',
                'sbmn_id' => 'SBMN00001',
                'rsm_create' => 1,
                'rsm_update' => 1,
                'rsm_destroy' => 1,
                'rsm_view' => 1,
            ],
            [
                'rlmn_id' => '2',
                'sbmn_id' => 'SBMN00002',
                'rsm_create' => 1,
                'rsm_update' => 1,
                'rsm_destroy' => 1,
                'rsm_view' => 1,
            ],
            [
                'rlmn_id' => '2',
                'sbmn_id' => 'SBMN00003',
                'rsm_create' => 1,
                'rsm_update' => 1,
                'rsm_destroy' => 1,
                'rsm_view' => 1,
            ],
        ]);
    }
}
