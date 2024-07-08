<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\SigninRequest;
use App\Service\User\UserService;
use App\DTO\UserDTO;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Models\User;

class AuthController extends Controller
{
	private UserService $userService;

	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}



	public function signin(SigninRequest $request): JsonResponse
	{
		// Get user object by DNI
		$user = $this->userService->getUserByDNI($request->dni);

		// Pass the user object to checkUserCredentials
		if ($user && $this->userService->checkUserCredentials($user, $request['password'])) {
			// Generate token using Laravel Passport.
			$token = $this->userService->generateJWToken($user);
			// Store user ID and token in Redis
			$stored = $this->userService->storeUserIDAndTokenRedis($user->id, $token);

			if ($stored) {
				$userDTO = new UserDTO(
					(string)$user->id,
					$token
				);
				// Return success response
				return response()->json($userDTO, 200);
			} else {
				// Handle error in storing token
				throw new HttpResponseException(response()->json([
					'message' => __('Failed to store session information. Please try again.')
				], 500));
			}
		} else {
			// Return error response for invalid credentials
			throw new HttpResponseException(response()->json([
				'message' => __('Wrong User Identication or Password.')
			], 401));
		}


		// 	if($this->userService->checkUserCredentials($request->dni, $request->password) == True)
		// 	{

		// 		$userID = $this->userService->getUserIDByDNI($request->dni);

		// 		if(empty($userID) == False){
		// 			$jwt = $this->userService->generateJWToken($userID);
		// 			$storedBool = $this->userService->storeUserIDAndTokenRedis($userID, $jwt);
		// 			if($storedBool == True){
		// 				$userDTO = new UserDTO(
		// 					(string)$userID,
		// 					$jwt
		// 				);

		// 				return response()->json($userDTO, 200);

		// 			}else{
		// 				throw new HttpResponseException(response()->json([
		// 				'message' => __(
		// 					'Something went wrong...'
		// 				)], 401));	
		// 			}
		// 		}else{
		// 			throw new HttpResponseException(response()->json([
		// 				'message' => __(
		// 					'Wrong User Identication or Password'
		// 				)], 401));
		// 		}

		// 	}else{

		// 		throw new HttpResponseException(response()->json([
		// 			'message' => __(
		// 				'Wrong User Identication or Password'
		// 			)], 401));
		// 	}

	}
}
