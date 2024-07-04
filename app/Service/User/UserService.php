<?php

declare(strict_types=1);

namespace App\Service\User;

use Illuminate\Support\Facades\Redis;
// use App\Models\User;
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

	public function checkUserCredentials($user, string $password): bool
	{
		if (!$user || !Hash::check($password, $user->password)) {
			return false;
		}
		return true;
	}


	// public function getUserIDByDNI(string $userDNI): string  | int | bool
	// {
	// 	$user = User::where('dni', $userDNI)->first();

	// 	if(empty($user) == False && empty($user->id) == False){
	// 		return $user->id;
	// 	}else{
	// 		return False;
	// 	}
	// }


	//public function generateJWToken(string $userID, string $issuerID)
	// public function generateJWToken(string | int $userID): string
	// {
	// 	if(is_numeric($userID)){
	// 		$userID = (string)$userID;
	// 	}


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

	// 	return $jwt;
	// }

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

	// public function getJWTokenByUserID(string | int $userID): string | int | bool
	// {
	// 	if(is_numeric($userID)){
	// 		$userID = (string)$userID;
	// 	}


	// 	try{

	// 		$jwt = $result = Redis::get('user:0:JWToken_'.$userID); //35 seconds 30*60=1800

	// 		if(is_string($jwt)){
	// 			return $jwt;
	// 		}else{
	// 			return False;
	// 		}
	// 	}catch (Exception $e){
	// 		return False;
	// 	}
	// }
}
