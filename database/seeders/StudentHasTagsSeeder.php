<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentHasTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $tags = Tag::all();

        
        foreach ($students as $student) {
            
            $student->tags()->sync(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    } 
    }

