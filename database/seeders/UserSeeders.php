<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeders extends Seeder
{
    public function run()
    {
        User::insert([
            'id' => '539',
            'email' => 'admin@jp.com',
            'role' => 'full-permit',
            'password' => Hash::make('123456')
        ]);
    }
}
