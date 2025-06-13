<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'sami', 'email' => 'sami@gmail.com', 'password' => 'ss123123'],
            ['name' => 'ahmad', 'email' => 'ahmad@gmail.com', 'password' => 'aa123123'],
            ['name' => 'malek', 'email' => 'malek@gmail.com', 'password' => 'mm123123'],
        ];

        foreach ($users as $data) {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }
    }
}
