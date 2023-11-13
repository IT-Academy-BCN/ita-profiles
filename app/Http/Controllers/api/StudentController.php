<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentListResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StudentController extends Controller
{    

    public function index()
    {
        $studentsList = Student::all();
        
        if (!$studentsList) {

            throw new HttpResponseException(response()->json([
                'message' => __('Alguna cosa ha anat malament.Intenta-ho de nou més tard.'
            )], 404));

        } elseif($studentsList->isEmpty()){

            throw new HttpResponseException(response()->json([
                'message' => __('No hi ha estudiants a la base de dades.'
            )], 404));
            
        }

        return response()->json([
            'data' => StudentListResource::collection($studentsList)], 200
        );

    }


    public function store(StoreStudentRequest $request)
    {

        $student = DB::transaction(function () use ($request) {

            $user = User::create([
                'name' => Str::lower($request->name),
                'surname' => Str::lower($request->surname),
                'dni' => Str::lower($request->dni),
                'email' => Str::lower($request->email),
                'password' => bcrypt($request->password),
                'active' => true,
            ]);

            $student = $user->student()->create([
                'subtitle' => $request->subtitle,
                'bootcamp' => $request->bootcamp,
            ]);

            $user -> assignRole('student');
    
            return $student;

        });

        if (!$student) {
            throw new HttpResponseException(response()->json([
                'message' => __('Registre no efectuat. Si-us-plau, torna-ho a provar.')],
            404));
        }
        
        return response()->json([
            'message' => __('Registre realitzat amb èxit.')], 201
        );
            
    }


    public function show($id){
         
        /**De moment no requereix autentificació */

        $student = Student::where('id', $id) -> first();
        
        if(!$student) {
            throw new HttpResponseException(response()->json(['message'=>__('Usuari no trobat.')], 404));
        }
        
        return response()->json([
            'data' => StudentResource::make($student)], 200
        );
           
    }


    public function update(UpdateStudentRequest $request, $id)
    {
        $user = Auth::User();

        $studentId = $user -> student -> id;
 
        if($studentId != $id){
            throw new HttpResponseException(response()->json([
                'message' => __('No autoritzat')], 401)
            );
        }

        $updatedStudent = DB::transaction(function () use ($request, $id) {
            
            $student = Student::where('id', $id) -> first();

            $student -> user -> name = Str::lower($request->name);
            $student -> user -> surname = Str::lower($request -> surname);
            $student -> user -> email = Str::lower($request -> email);
            $student -> subtitle = $request -> subtitle;
            $student -> bootcamp = $request -> bootcamp;
            $student -> about  = $request-> about;
            $student -> cv = $request-> cv;
            $student -> linkedin = Str::lower($request-> linkedin);
            $student -> github = Str::lower($request-> github);

            $student -> user -> save();
            $student -> save();

            return $student;
        });

        if (!$updatedStudent) {
            throw new HttpResponseException(response()->json(['message'=>__('Alguna cosa ha anat malament.
            Torna-ho a intentar més tard.')], 404));
        }

        return response()->json([
            'data' => StudentResource::make($updatedStudent)], 200
        );
    }


    public function destroy($id) {

        $user = Auth::User();

        $studentId = $user -> student -> id;

        if($studentId != $id){
            throw new HttpResponseException(response()->json([
                'message' => __('No autoritzat')], 401)
            );
        }
        
        $deleteStudent = DB::transaction(function() use ($id) {
            $student = Student::where('id', $id) -> first();
            $user = $student -> user;
            $student -> delete();
            $user -> delete();
            return true;
        });

        if(!$deleteStudent) {
            throw new HttpResponseException(response()->json(['message'=>__('Alguna cosa ha anat malament.
            Torna-ho a intentar més tard.')], 404));
        }

        return response()->json([
            'message' => __("T'has donat de baixa com a estudiant d'It Profiles.")], 200
        );

    }

} 