<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'user_name'=>"admin",
             'name' => 'admin',
             'email' => 'adimn@gmail.com',
             'password' => Hash::make("12345678"),
             "age" =>"22",
             "role_id" => 1,
         ]);
    }
}
