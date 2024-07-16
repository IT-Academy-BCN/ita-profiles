<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\SigninRequest;
use App\Service\User\UserService;
use App\DTO\UserDTO;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserNotFoundInRedisException;
use App\Exceptions\UserNotStoredInRedisException;
use App\Exceptions\CouldNotCreateJWTokenPassportException;
use App\Exceptions\InvalidCredentialsException;
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
			$user = $this->userService->getUserByDNI($request->dni);

			$this->userService->checkUserCredentials($user, $request['password']);

			$token = $this->userService->generateJWToken($user);

			$this->userService->storeUserIDAndTokenRedis($user->id, $token);

			$userDTO = new UserDTO(
				(string)$user->id,
				$token
			);

			return response()->json($userDTO, 200);
		} catch (UserNotFoundException | InvalidCredentialsException | UserNotFoundInRedisException | UserNotStoredInRedisException | CouldNotCreateJWTokenPassportException $e) {
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?:  500);
		} catch (Exception $e) {
			return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
		}
	}
}
