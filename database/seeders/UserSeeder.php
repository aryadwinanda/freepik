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
        // check if user 'admin' already exists
        if (User::where('email', 'admin@example.com')->doesntExist()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        } else {
            $user = User::where('email', 'admin@example.com')->first();
            $user->update([
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }
    }
}
