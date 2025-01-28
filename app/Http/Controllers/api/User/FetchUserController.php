<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class FetchUserController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $query = User::query()->with(['student', 'recruiter']);

        if ($request->has('type') && !in_array($request->type, ['student', 'recruiter'])) {
            return response()->json([
                'message' => 'Invalid type. Allowed values are "student" or "recruiter".'
            ], 400);
        }
        
        if ($request->has('type')) {
            if ($request->type === 'student') {
                // Filter users who are students
                $query->has('student')->doesntHave('recruiter');
            } elseif ($request->type === 'recruiter') {
                $query->has('recruiter')->doesntHave('student');
            }
        }

        $users = $query->get();

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => $users,
        ], 200);
    }
}
