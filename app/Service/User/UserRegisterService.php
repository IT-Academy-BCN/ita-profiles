<?php

declare(strict_types=1);

namespace Service\User;

use App\Http\Requests\RegisterRequest;
use App\Models\Resume;
use App\Models\Student;
use App\Models\User;
class UserRegisterService
{

    public function createUser(RegisterRequest $registerData): array
    {
        $input = $registerData->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $student = new Student();
        $student->user_id = $user->id; 
        $student->save();
        $resume = new Resume();
        $resume->student_id = $student->id; 
        $resume->specialization = $input['specialization']; 
        $resume->save();

        $success['token'] = $user->createToken('ITAcademy')->accessToken;
        $success['email'] = $user->email;

        return $success;

    }
    
}
