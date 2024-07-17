<?php

declare(strict_types=1);

namespace App\Service\User;

use Illuminate\Support\Facades\Redis;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserNotFoundInRedisException;
use App\Exceptions\UserNotStoredInRedisException;
use App\Exceptions\CouldNotCreateJWTokenPassportException;
use App\Exceptions\InvalidCredentialsException;

class UserService
{
	private int $expirationTime_s = 60 * 30; //30 minutes expiration time
	private string $JWTokenRedisPre = 'user:0:JWToken_';

	private $redis;

	public function __construct()
	{
		$this->redis = new Redis();
	}

	public function checkUserCredentials(User $user, string $password): bool
	{
		if (!$user || !Hash::check($password, $user->password)) {
			throw new InvalidCredentialsException();
		}
		return true;
	}

	public function getUserByDNI(string $userDNI): User
	{
		$user = User::where('dni', $userDNI)->first();

		if (!$user) {
			throw new UserNotFoundException($userDNI);
		}
		return $user;
	}

	public function generateJWToken(User $user): string
	{
		$jwt = $user->createToken('loginToken')->accessToken;

		if (!$jwt) {
			throw new CouldNotCreateJWTokenPassportException($user->id);
		}
		return $jwt;
	}

	public function storeUserIDAndTokenRedis(string $userID, string $token): bool
	{
		try {
			$result = Redis::set($this->JWTokenRedisPre . $userID, $token, 'EX', $this->expirationTime_s);
			if (!$result) {
				throw new UserNotStoredInRedisException($userID);
			}
			return true;
		} catch (Exception $e) {
			throw new UserNotStoredInRedisException($userID);
		}
	}

	public function getJWTokenByUserID(string $userID): string
	{
		$jwt = Redis::get('user:0:JWToken_' . $userID);

		if (!$jwt) {
			throw new UserNotFoundInRedisException($userID);
		}
	
		return $jwt;
	}
}
