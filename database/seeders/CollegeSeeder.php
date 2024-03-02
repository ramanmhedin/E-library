<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colleges = [
            "Engineering",
            "Science",
            "Education",
            "Law",
            "Sports",
            "Administration & Economic",
            "Medical",
            "Art",
            "Agriculture",
            "Languages",
            "Basic Education",
            "Islamic Science"
        ];
    foreach ($colleges as $college){
        College::query()->create(["name" => $college]);
    }
    }
}
