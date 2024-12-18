<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_values')->insert([
            [
                'val_prefix' => 'RL',
                'val_value' => 1,
                'val_for' => 'for Role ID'
            ],
            [
                'val_prefix' => 'USR',
                'val_value' => 1,
                'val_for' => 'for User ID'
            ],
            [
                'val_prefix' => 'MN',
                'val_value' => 1,
                'val_for' => 'for Menu ID'
            ],
            [
                'val_prefix' => 'SBMN',
                'val_value' => 1,
                'val_for' => 'for Sub Menu ID'
            ],
        ]);
    }
}
