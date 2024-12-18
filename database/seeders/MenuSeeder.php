<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_menus')->insert([
            [
                'mn_id' => 'MN00001',
                'mn_prefix' => 'dshbrd',
                'mn_detail' => 'Dashboard',
                'mn_reference' => 'dashboard',
                'mn_icon' => 'fa-home',
            ],
            [
                'mn_id' => 'MN00002',
                'mn_prefix' => 'sttng',
                'mn_detail' => 'Settings',
                'mn_reference' => 'settings',
                'mn_icon' => 'fa-tools',
            ],
        ]);
    }
}
