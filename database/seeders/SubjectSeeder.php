<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicDegrees = ['bachelor', 'master', 'doctoral'];
        $numberOfSubjects = 3;

        // Get all departments
        $departments = Department::with("college")->get();

        // Loop through each department and assign subjects
        $departments->each(function ($department) use ($numberOfSubjects, $academicDegrees) {
            // Get the associated college for the department
            $college = $department->college;

            // Generate subjects for the department
            for ($i = 1; $i <= $numberOfSubjects; $i++) {
                $subjectName = "Test_{$department->name}_$i";
                $description = "Description for $subjectName";
                $academicDegree = $academicDegrees[array_rand($academicDegrees)];

                Subject::create([
                    'name' => $subjectName,
                    'description' => $description,
                    'academic_degree' => $academicDegree,
                    'department_id' => $department->id,
                    'college_id' => $college->id,
                ]);
            }
        });
    }
}
