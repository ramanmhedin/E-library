<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Type\Integer;

class PresidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Get the role ID for student

        // Get all subjects, colleges, and departments
        $colleges=College::all();        // Generate fake student records
        foreach ($colleges as $college) {
                User::create([
                    'user_name' => $faker->userName,
                    'name' => "President".$faker->firstName . ' ' . $faker->lastName,
                    'email' => $faker->unique()->safeEmail,
                    'password' => Hash::make("12345678"),
                    'age' => $faker->numberBetween(18, 50),
                    'role_id' => 4,
                    'subject_id' => null,
                    'college_id' => $college->id,
                    'department_id' => null,
                ]);

            }

    }
}
