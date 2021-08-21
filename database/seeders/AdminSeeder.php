<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'      => 'user',
                'email'     => 'user@user.com',
                'password'  => Hash::make('useruser'),
                'role'      => 1
            ],
            [
                'name'      => 'moder',
                'email'     => 'moder@moder.com',
                'password'  => Hash::make('modermoder'),
                'role'      => 2
            ],
            [
                'name'      => 'admin',
                'email'     => 'admin@admin.com',
                'password'  => Hash::make('adminadmin'),
                'role'      => 3
            ],
        ]);
    }
}
