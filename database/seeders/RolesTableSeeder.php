<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'description' => 'Administrator Role'],
            ['name' => 'Student', 'description' => 'Regular User Role'],
            ['name' => 'Teacher', 'description' => 'Regular User Role'],
            ['name' => 'President', 'description' => 'Regular User Role'],
            // Add more roles as needed
        ];

        // Loop through the roles array and create records in the database
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
