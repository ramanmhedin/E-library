<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Monolog\Handler\SyslogUdp\UdpSocket;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Get the role ID for student

        // Get all subjects, colleges, and departments
        $departments = Department::with(["college", "subjects"])->whereHas("subjects")->get();
        // Generate fake student records
        foreach ($departments as $department) {
            $subjects = $department->subjects;
            foreach ($subjects as $subject) {
                for ($i = 0; $i < 3; $i++) {
                    User::create([
                        'user_name' => $faker->userName,
                        'name' => $faker->firstName . ' ' . $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'password' => Hash::make("12345678"),
                        'age' => $faker->numberBetween(18, 50),
                        'role_id' => 2,
                        'subject_id' => $subject->id,
                        'college_id' => $department->college->id,
                        'department_id' => $department->id,
                    ]);
                }
            }
        }
    }
}
