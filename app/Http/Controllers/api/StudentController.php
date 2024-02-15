<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $studentsList = Student::all();

        return response()->json(
            [
                'data' => StudentResource::collection($studentsList)],
            200
        );

    }

    public function store(StoreStudentRequest $request)
    {
        $student = DB::transaction(function () use ($request) {

            return Student::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'photo' => $request->photo,
                'status' => $request->status,
            ]);
        });
        if (!$student) {
            throw new HttpResponseException(response()->json(
                [
                'message' => __('Registre no efectuat. Si-us-plau, torna-ho a provar.')],
                404
            ));
        }
        return response()->json([
            'message' => __('Registre realitzat amb èxit.'),
            'data' => new StudentResource($student)
        ], 201);
    }

    public function show(Student $student)
    {
        return response()->json(['data' => StudentResource::make($student)], 200);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $updatedStudent = DB::transaction(function () use ($request, $student) {

            $student->name = $request->name;
            $student->surname = $request->surname;
            $student->photo = $request->photo;
            $student->status = $request->status;
            $student->save();

            return $student;
        });

        return response()->json(
            ['message' => __('Estudiant actualitzat amb èxit.'),
            'data' => new StudentResource($student)],
            200
        );
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $student->delete();
            return true;
        });

        return response()->json(
            [
                'message' => __("T'has donat de baixa com a estudiant d'It Profiles.")],
            200
        );

    }
}
