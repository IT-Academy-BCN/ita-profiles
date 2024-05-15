<?php

declare(strict_types=1);

namespace Service\User;

use App\Http\Requests\RegisterRequest;
use App\Models\Resume;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRegisterService
{

    public function createUser(RegisterRequest $registerData): array
    {
		/*
		$input = $registerData->all();
        $input['password'] = bcrypt($input['password']);
		
		DB::transaction(function() {
			$user = User::create($input);
			$student = new Student();
			$student->user_id = $user->id; 
			$student->save();
			$resume = new Resume();
			$resume->student_id = $student->id; 
			$resume->specialization = $input['specialization']; 
			$resume->save();
		});

        $success['token'] = $user->createToken('ITAcademy')->accessToken;
        $success['email'] = $user->email ?? Null;

        return $success;
        */
        
        $input = $registerData->all();
        $input['password'] = bcrypt($input['password']);
		$user = new User;
		$student = new Student;
		$resume = new Resume;
        try {
			
			DB::beginTransaction();
			
			$user = User::create($input);
			
			$student->user_id = $user->id; 
			$student->save();
			
			$resume->student_id = $student->id; 
			$resume->specialization = $input['specialization']; 
			$resume->save();
			
			$success['token'] = $user->createToken('ITAcademy')->accessToken;
			
			
			DB::commit();
		} catch (\PDOException $e) {
			// Woopsy
			DB::rollBack();
		}
		
		
        $success['email'] = $user->email;
		
		return $success;
        /*
        
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

		*/
    }
    
}
