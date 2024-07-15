<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;

class EnsureStudentOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Extract the value of the parameter studentId from the route:
        $studentID = $request->route('studentId');
        //$studentID  = request()->route('studentId');
        if(!$studentID){
            echo $studentID;
            return response()->json(['error' => 'URL Not found'], 407); //404
        }

        //Obtain the user ID from the JWToken using passport:
        $userID = Auth::user()->id;
        if(!$userID){
            return response()->json(['error' => 'Auth Error'], 402);
        }
        
        //Check that both, user and student exist, if not return error.
        $user = User::find($userID);
        $student = Student::find($studentID);
        if(!$user || !$student){
            return response()->json(['error' => 'URL Error'], 407);  //404
        }

        //If userID is the same in Student continue as success:
        if($user->id === $student->user_id){
            return $next($request);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        
    }
}
