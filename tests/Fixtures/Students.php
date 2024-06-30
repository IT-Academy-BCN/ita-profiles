<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Models\Bootcamp;
use App\Models\Resume;
use App\Models\Student;
use Illuminate\Support\Facades\Date;

class Students
{
    public static function aStudent(): Student
    {
        return Student::factory()->create([
            'name' => 'Dokuta',
            'surname' => 'Suranpu',
            'photo' => 'Arale',
        ]);
    }

    public static function aStudentWithResume(): Student
    {
        $student =  Student::factory()->create();
        Resume::factory()->for($student)->create();
        return $student->refresh();
    }

    public static function aStudentWithOneBootcamp(): Student
    {
        $student =  self::aStudentWithResume();
        $bootcamp = Bootcamp::factory()->create();
        $student->resume->bootcamps()->attach($bootcamp->id, ['end_date' => Date::now()->subYear()->addDays(rand(1, 365))]);
        return $student->refresh();
    }

    public static function aStudentWithTwoBootcamps(): Student
    {
        $student =  self::aStudentWithResume();

        $bootcamp1 = Bootcamp::factory()->create();
        $bootcamp2 = Bootcamp::factory()->create();

        $student->resume->bootcamps()->attach($bootcamp1->id, ['end_date' => Date::now()->subYear()->addDays(rand(1, 365))]);
        $student->resume->bootcamps()->attach($bootcamp2->id, ['end_date' => Date::now()->subYear()->addDays(rand(1, 365))]);

        return $student->refresh();
    }

    public static function aStudentWithoutResume(): Student
    {
        return Student::factory()->create();
    }
}
