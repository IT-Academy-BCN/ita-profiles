<?php

declare(strict_types=1);

namespace App\Service\User;

use Illuminate\Support\Facades\Redis;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

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

	// This function could get ID from user model instead of doing it from DNI to avoid another query (GetUserID) 
	// or just use $user->id in the rest of functions and instead of passing an ID pass the user object.
	public function getUserIDByDNI(string $userDNI): string  | int | bool
	{
		$user = User::where('dni', $userDNI)->first();

		if ($user && $user->id) {
			return $user->id;
		}
		// I think here it should return an exception instead of false.
		return false;
	}

	// If we finally use this function we have to create the tests.
	public function getUserByDNI(string $userDNI): User | bool
	{
		$user = User::where('dni', $userDNI)->first();

		if (!$user) {
			// Return exception instead of false.
			return false;
		}
		// I think here it should return an exception instead of false.
		return $user;
	}

	public function generateJWToken(User $user): string
	{
		// if(is_numeric($userID)){
		// 	$userID = (string)$userID;
		// }

		// 	// Create token header as a JSON string
		// 	$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

		// 	// Create token payload as a JSON string
		// 	$payload = json_encode(['user_id' => $userID]);

		// 	// Encode Header to Base64Url String
		// 	$base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

		// 	// Encode Payload to Base64Url String
		// 	$base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

		// 	// Create Signature Hash
		// 	//https://www.php.net/manual/en/function.hash-hmac.php
		// 	$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->key_hash_mac, true);

		// 	// Encode Signature to Base64Url String
		// 	$base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

		// 	// Create JWT
		// 	$jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
		$jwt = $user->createToken('loginToken')->accessToken;

		return $jwt;
	}

	public function storeUserIDAndTokenRedis(string | int $userID, string $token): bool
	{
		if (is_numeric($userID)) {
			$userID = (string)$userID;
		}

		try {
			$result = Redis::set($this->JWTokenRedisPre . $userID, $token, 'EX', $this->expirationTime_s); //35 seconds 30*60=1800
			if ($result == True) {
				return True;
			} else {
				return False;
			}
		} catch (Exception $e) {
			return False;
		}
	}

	public function getJWTokenByUserID(string | int $userID): string | int | bool
	{
		if (is_numeric($userID)) {
			$userID = (string)$userID;
		}

		try {
			$jwt = $result = Redis::get('user:0:JWToken_' . $userID); //35 seconds 30*60=1800

			if (is_string($jwt)) {
				return $jwt;
			} else {
				return False;
			}
		} catch (Exception $e) {
			return False;
		}
	}
}
