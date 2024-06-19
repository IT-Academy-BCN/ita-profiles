<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\SigninRequest;
use App\Service\User\UserService;
use App\DTO\UserDTO;
use Illuminate\Http\Exceptions\HttpResponseException;


class AuthController extends Controller
{
	private UserService $userService;
	
	public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

	
    
    public function signin(SigninRequest $request)
	{
		
		if($this->userService->checkUserCredentials($request->dni, $request->password) == True)
		{

			$userID = $this->userService->getUserIDByDNI($request->dni);
			
			if(empty($userID) == False){
				$jwt = $this->userService->generateJWToken($userID);
				$storedBool = $this->userService->storeUserIDAndTokenRedis($userID, $jwt);
				if($storedBool == True){
					$userDTO = new UserDTO(
						$userID,
						$jwt
					);
					
					return response()->json($userDTO, 200);
					
				}else{
					throw new HttpResponseException(response()->json([
					'message' => __(
						'Something went wrong...'
					)], 401));	
				}
			}else{
				throw new HttpResponseException(response()->json([
					'message' => __(
						'Wrong User Identication or Password'
					)], 401));
			}

		}else{
			
			throw new HttpResponseException(response()->json([
				'message' => __(
					'Wrong User Identication or Password'
				)], 401));
		}

	}

    
    
    
}
