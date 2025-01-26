<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use DragonCode\PrettyArray\Services\Formatters\Json;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\RegisterRecruiterRequest;
use App\Models\User;
use App\Models\Recruiter;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RegisterRecruiterController extends Controller
{
    public function __invoke(RegisterRecruiterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'dni' => $data['dni'],
            'password' => Hash::make($data['password']),
        ]);

        $role = Role::where('name', 'recruiter')->where('guard_name', 'api')->first();

        if (!$role) {
            return response()->json(['error' => 'Role "recruiter" not found'], 400);
        }

        $recruiter = Recruiter::create([
            'user_id' => $user->id,
            'company_id' => $data['company_id'],
            'role_id' => $role->id,
        ]);

        return response()->json([
            'message' => 'Recruiter created successfully',
            'recruiter' => $recruiter,
            'user' => $user,
        ], 201);

    }
}
