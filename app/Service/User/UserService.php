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

class UserService
{

	// private string $key_hash_mac = "";
	private int $expirationTime_s = 60 * 30; //30 minutes expiration time
	private string $JWTokenRedisPre = 'user:0:JWToken_';

	private $redis;

	public function __construct()
	{
		// $this->key_hash_mac = env('KEY_HASH_MAC', "CHANGE_MY_IN_ENV_Password");		
		$this->redis = new Redis();
	}

	// PASAR MODEL, DNI y PASSWORD
	public function checkUserCredentials(User $user, string $password): bool
	{
		if (!$user || !Hash::check($password, $user->password)) {
			return false;
		}
		return true;
	}

	// If we finally use this function we have to create the tests.
	public function getUserByDNI(string $userDNI): User | bool
	{
		$user = User::where('dni', $userDNI)->first();

		if (!$user) {
			throw new UserNotFoundException($userDNI);
		}
		// I think here it should return an exception instead of false.
		return $user;
	}

	public function generateJWToken(User $user): string
	{
		$jwt = $user->createToken('loginToken')->accessToken;
		
		if(!$jwt){
			throw new CouldNotCreateJWTokenPassportException($user->id);
		}
		
		return $jwt;
	}

	public function storeUserIDAndTokenRedis(string | int $userID, string $token): bool
	{
		if (is_numeric($userID)) {
			$userID = (string)$userID;
		}

		try
		{
			$result = Redis::set($this->JWTokenRedisPre . $userID, $token, 'EX', $this->expirationTime_s); //35 seconds 30*60=1800
			if (!$result) {
				throw new UserNotStoredInRedisException($userID);
			}
			return True;
			
		}catch (Exception $e) {
			throw new UserNotStoredInRedisException($userID);
		}
	}

	public function getJWTokenByUserID(string | int $userID): string | int | bool
	{
		if (is_numeric($userID)) {
			$userID = (string)$userID;
		}

		try {
			$jwt = $result = Redis::get('user:0:JWToken_' . $userID); //35 seconds 30*60=1800

			if(!$jwt)
			{
				throw new UserNotFoundInRedisException($userID);
			}

			return $jwt;
			

		}catch(Exception $e) {
			throw new UserNotFoundInRedisException($userID);
		}
	}
}
