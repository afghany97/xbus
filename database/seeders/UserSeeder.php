<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Muhammad Reda",
            "email" => "muhammadreda97@gmail.com",
            "password" => Hash::make("123456789")
        ]);
    }
}
