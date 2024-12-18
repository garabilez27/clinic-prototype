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
                'mn_sequence' => 1,
                'mn_branched' => 0,
                'mn_has_actions' => 0,
            ],
            [
                'mn_id' => 'MN00002',
                'mn_prefix' => 'sttng',
                'mn_detail' => 'Settings',
                'mn_reference' => 'settings',
                'mn_icon' => 'fa-tools',
                'mn_sequence' => 999,
                'mn_branched' => 1,
                'mn_has_actions' => 1,
            ],
            [
                'mn_id' => 'MN00003',
                'mn_prefix' => 'ptt',
                'mn_detail' => 'Patients',
                'mn_reference' => 'ptt.index',
                'mn_icon' => 'fa-user',
                'mn_sequence' => 2,
                'mn_branched' => 0,
                'mn_has_actions' => 1,
            ],
        ]);
    }
}
