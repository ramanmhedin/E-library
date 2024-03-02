<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departmentsList = [
            "Science" => [
                "Biology",
                "Chemistry",
                "Physics",
                "Mathematics",
                "Earth Sciences And Petroleum",
                "Computer Science And IT",
                "Environmental Science And Health",
            ],
            "Engineering" => [
                "Civil",
                "Electrical",
                "Architectural",
                "Software",
                "Water Resources",
                "Geomagnetic (Surveying)",
                "Mechanical and Mechatronics",
                "Chemical and Petrochemical",
                "Aviation",
            ],
            "Education" => [
                "Chemistry",
                "Biology",
                "Mathematics",
                "Physics",
                "English",
                "Arabic",
                "Kurdish",
                "Syriac",
                "Special Education",
            ],
            "Languages" => [
                "Kurdish",
                "Arabic",
                "English",
                "Persian",
                "French",
                "Turkish",
                "German",
                "Chinese",
                "Translation",
            ],

        ];

        foreach ($departmentsList as $collegeName => $departments) {
            // Retrieve the college by name
            $college = College::where('name', $collegeName)->first();

            if ($college) {
                // Assign departments to the college
                foreach ($departments as $department) {
                    Department::create([
                        'name' => $department,
                        'college_id' => $college->id,
                    ]);
                }
            }
        }
    }
}
