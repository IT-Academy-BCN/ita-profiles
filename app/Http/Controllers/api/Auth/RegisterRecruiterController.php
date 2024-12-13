<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRecruiterRequest;
use Illuminate\Http\JsonResponse;
use App\Models\{Recruiter, User};
use Illuminate\Support\Facades\{DB, Log, Hash};
use Illuminate\Support\Str;

class RegisterRecruiterController extends Controller
{
    /**
     * Handle recruiter registration.
     */
    public function register(RegisterRecruiterRequest $request): JsonResponse
    {
        $input = $request->validated();

        DB::beginTransaction();

        try {
            // Create the user
            $user = User::create([
                'id' => Str::uuid()->toString(),
                'username' => $input['username'],
                'dni' => $input['dni'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            // Create the recruiter
            $recruiter = Recruiter::create([
                'id' => Str::uuid()->toString(),
                'company_id' => $input['company_id'],
                'user_id' => $user->id,
                'role' => 'recruiter',
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Recruiter registered successfully.',
                'user' => $user,
                'recruiter' => $recruiter,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Recruiter registration failed:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to register recruiter.',
            ], 500);
        }
    }
}
