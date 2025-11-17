<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([

            'uuid' => Str::uuid(),
            'role_id' => 1, // Assuming role_id = 1 for admin
            'admin_code' => 130000,
            'name' => 'Ulaş Körpe',
            'email' => 'ulaskorpe@gmail.com',
            'password' => Hash::make('123123'), // Hash the password
            'image' => '', // Default image
            'phone' => '5066063000',
            'api_token' => Str::random(60), // Generate a random API token
            'status' => 1, // Active status
        ]);
    }
}
