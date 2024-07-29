<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@mail.com';
        
        if (User::where('email', $email)->doesntExist()) {
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        } else {
            $user = User::where('email', $email)->first();
            $user->update([
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        $email = 'user@mail.com';
        
        if (User::where('email', $email)->doesntExist()) {
            User::create([
                'name' => 'User',
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'user',
            ]);
        } else {
            $user = User::where('email', $email)->first();
            $user->update([
                'password' => bcrypt('password'),
                'role' => 'user',
            ]);
        }
    }
}
