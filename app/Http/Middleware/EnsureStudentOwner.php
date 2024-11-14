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
        // Extract the value of the parameter studentId from the route:
        $studentID = $request->route('studentId');

        if (!$studentID) {
            return response()->json(['error' => 'Student ID not found'], 404); // Changed to 404
        }

        // Obtain the user ID from the JWToken using passport:
        $userID = Auth::user()->id;
        if (!$userID) {
            return response()->json(['error' => 'Authentication Error'], 401); // Correct code for authentication issues
        }

        // Check that both, user and student exist, if not return error.
        $user = User::find($userID);
        $student = Student::find($studentID);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404); // Changed to 404
        }
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404); // Changed to 404
        }

        // If userID is the same in Student continue as success:
        if ($user->id === $student->user_id) {
            return $next($request);
        } else {
            return response()->json(['error' => 'Unauthorized'], 403); // Correctly use 403 for unauthorized access
        }
    }
}
