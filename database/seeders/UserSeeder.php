<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'avatar' => 'images/avatars/avatar1.jpg',
        ]);

        $admin->assignRole('admin');

        User::factory()->create([
            'name' => 'David',
            'username' => 'david',
            'email' => 'david@example.com',
            'password' => Hash::make('asdf'),
            'avatar' => 'images/avatars/avatar1.jpg',
        ]);

        User::factory()->create([
            'name' => 'Marta',
            'username' => 'marta',
            'email' => 'marta@gmail.com',
            'password' => Hash::make('123'),
            'avatar' => 'images/avatars/avatar2.jpg',
        ]);

        User::factory()->create([
            'name' => 'Roberto',
            'username' => 'roberto',
            'email' => 'roberto@gmail.com',
            'password' => Hash::make('123'),
            'avatar' => 'images/avatars/avatar4.jpg',
        ]);
    }
}
