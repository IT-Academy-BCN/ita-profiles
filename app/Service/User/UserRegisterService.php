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

    public function createUser(RegisterRequest $registerData): array | bool
    {
		
        $input = $registerData->all();
        
        //Workaround...createToken needs email?
        if(empty($input['email'])){
			return False;
		}
        
        $input['password'] = bcrypt($input['password']);
		$user = new User;
		$student = new Student;
		$resume = new Resume;
        try {
			
			DB::beginTransaction();
			
			$user = User::create($input);
			
			$user = $user->fresh();

			$student->user_id = $user->id; 
			$student->save();

			$resume->student_id = $student->id; 
			$resume->specialization = $input['specialization']; 
			$resume->save();

			$resume = $resume->fresh();
			
			$success['token'] = $user->createToken('ITAcademy')->accessToken;
			
			DB::commit();
		} catch (\PDOException $e) {
			// Woopsy
			DB::rollBack();
			return False;
			
		} catch (Exception $e){
			// Woopsy
			DB::rollBack();
			return False;
		}

        $success['email'] = $user->email;
		
		return $success;
		//return False;
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
