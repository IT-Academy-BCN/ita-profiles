<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\SigninRequest;
use App\Service\User\UserService;
use App\DTO\UserDTO;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserNotFoundInRedisException;
use App\Exceptions\UserNotStoredInRedisException;
use App\Exceptions\CouldNotCreateJWTokenPassportException;

use Exception;

class AuthController extends Controller
{
	private UserService $userService;

	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}

	public function signin(SigninRequest $request): JsonResponse
	{
		try {
			// Get user object by DNI
			$user = $this->userService->getUserByDNI($request->dni);

			// Pass the user object to checkUserCredentials
			if ($this->userService->checkUserCredentials($user, $request['password'])) {
				// Generate token using Laravel Passport.
				$token = $this->userService->generateJWToken($user);
				// Store user ID and token in Redis
				$this->userService->storeUserIDAndTokenRedis($user->id, $token);
				//Create UserDTO to return it as a JSON Response
				$userDTO = new UserDTO(
					(string)$user->id,
					$token
				);
				// Return success response
				return response()->json($userDTO, 200);
			} else {
				// Return error response for invalid credentials
				throw new HttpResponseException(response()->json([
					'message' => ('Wrong User Identication or Password.')
				], 401));
			}
		} catch (UserNotFoundException | UserNotFoundInRedisException | UserNotStoredInRedisException | CouldNotCreateJWTokenPassportException $e) {
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?:  500);
		} catch (Exception $e) {
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
		}
	}
}
