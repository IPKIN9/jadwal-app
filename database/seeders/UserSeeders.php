<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeders extends Seeder
{
    public function run()
    {
        $uuid = Uuid::uuid4()->toString();

        User::insert([
            'id'       => crc32($uuid),
            'nama'     => 'oned',
            'email'    => 'admin@mail.com',
            'role'     => 'crud-list',
            'password' => Hash::make('nurulponga@unyu'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
