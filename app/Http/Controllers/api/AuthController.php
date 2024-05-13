<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
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

	
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('dni', 'password');

            $user = $this->verifyUser($credentials);
            /** @var \App\Models\User $user * */
            $token = $user->createToken('auth_token')->accessToken;

            return response()->json([
                'message' => __('Autenticació amb èxit. Benvingut'),
                'name' => ucwords($user->name),
                'token' => $token,
            ], 200);

        } catch (Exception $validationException) {
            return response()->json(
                ['message' => __($validationException->getMessage())],
                $validationException->getCode()
            );
        }
    }

    private function verifyUser(array $credentials)
    {

        if (! Auth::attempt($credentials)) {
            throw new Exception(__('Credencials invàlides, comprova-les i torneu a iniciar sessió'), 401);
        }

        return Auth::user();
    }

    public function logout()
    {
        $user = Auth::user();
        /** @var \App\Models\User $user * */
        $user->tokens()->delete();

        return response()->json(['message' => __('Desconnexió realitzada amb èxit')], 200);

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
