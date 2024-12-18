<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_sub_menus')->insert([
            [
                'sbmn_id' => 'SBMN00001',
                'sbmn_detail' => 'Menus',
                'sbmn_reference' => 'mn.index',
                'sbmn_icon' => 'fa-bars',
                'mn_id' => 'MN00002',
            ],
            [
                'sbmn_id' => 'SBMN00002',
                'sbmn_detail' => 'Sub Menus',
                'sbmn_reference' => 'sbmn.index',
                'sbmn_icon' => 'fa-code-branch',
                'mn_id' => 'MN00002',
            ],
            [
                'sbmn_id' => 'SBMN00003',
                'sbmn_detail' => 'Roles',
                'sbmn_reference' => 'rl.index',
                'sbmn_icon' => 'fa-user-tag',
                'mn_id' => 'MN00002',
            ],
        ]);
    }
}
