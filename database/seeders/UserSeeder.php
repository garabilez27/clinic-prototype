<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_users')->insert([
            [
                'usr_id' => 'USR00001',
                'usr_fname' => 'Dev',
                'usr_lname' => '00',
                'usr_email' => 'dev00@gmail.com',
                'usr_password' => Hash::make('12345678'),
                'rl_id' => 'RL00001',
            ],
            [
                'usr_id' => 'USR00002',
                'usr_fname' => 'Admin',
                'usr_lname' => '00',
                'usr_email' => 'admin00@gmail.com',
                'usr_password' => Hash::make('12345678'),
                'rl_id' => 'RL00002',
            ],
        ]);
    }
}
