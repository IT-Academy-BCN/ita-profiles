<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Resources\StudentCreateResource;
use App\Http\Resources\StudentListResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {

        $studentsList = Student::all();

        if (!$studentsList) {
            throw new HttpResponseException(response()->json(['message' => 'Something went wrong. Please try again.'], 404));
        }

        return response()->json([
            'data' => StudentListResource::collection($studentsList),
            'status' => 200,
        ]);

    }

    public function store(StoreStudentRequest $request)
    {

        $user = DB::transaction(function () use ($request) {

            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'dni' => $request->dni,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'active' => true,
            ]);

            $user->student()->create([
                'subtitle' => $request->subtitle,
                'bootcamp' => $request->bootcamp,
            ]);

            return $user;

        });

        if (!$user) {
            throw new HttpResponseException(response()->json(['message' => __('Registre no efectuat. Si-us-plau, torna-ho a provar.')], 404));
        }

        $student = $user->student;

        return response()->json([
            'data' => StudentCreateResource::make($student),
            'status' => 201,
        ]);

    }
}
