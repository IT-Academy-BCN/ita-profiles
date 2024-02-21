<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $studentsList = Student::paginate(10);

        return StudentResource::collection($studentsList);
    }

    public function store(StoreStudentRequest $request)
    {
        try {
            $student = DB::transaction(function () use ($request) {
                return Student::create($request->validated());
            });

            return response()->json([
                'message' => __('Registre realitzat amb èxit.'),
                'data' => new StudentResource($student)
            ], Response::HTTP_CREATED); // 201
        } catch (QueryException $e) {
            return response()->json([
                'message' => __('Registre no efectuat. Si-us-plau, torna-ho a provar.'),
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST); // 400
        }
    }

    public function show(Student $student)
    {
        return StudentResource::make($student);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        DB::transaction(function () use ($request, $student) {

            $student->name = $request->name;
            $student->surname = $request->surname;
            $student->photo = $request->photo;
            $student->status = $request->status;
            $student->save();

            return $student;
        });

        return StudentResource::make($student);
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $student->delete();
        });
        return response()->json(null, 204);
    }
}
