<?php

namespace App\Service\User;

use Illuminate\Support\Facades\Redis;
use App\Models\User;

class UserService
{

	private string $key_hash_mac = "";
	//private string $key_hash_mac = "passwordOne";
	private int $expirationTime_s = 60*30; //30 minutes expiration time
	
	private $redis;
	
	public function __construct()
	{
		$this->key_hash_mac = env('KEY_HASH_MAC', "passwordOne");
		
		//$this->redis = new Redis();
		
	}

	public function checkUserCredentials(string $userDNI, string $password): bool
	{
		$user = User::where('dni', $userDNI)->first();
		
		if(empty($user) == False && empty($user->password) == False){
			try{

				//if($user->password == bcrypt($password)){
				if(password_verify($password, $user->password)){
					return True;
				}else{
					return False;
				}
				
			}catch (Exception $e){
				return False;
			}
		}else{
			return True;
		}
	}
	
	public function getUserIDByDNI(string $userDNI): string
	{
		$user = User::where('dni', $userDNI)->first();
		
		if(empty($user) == False){
			return $user->id;
		}else{
			return False;
		}
	}
	
	
	//public function generateJWToken(string $userID, string $issuerID)
	public function generateJWToken(string $userID)
	{
		// Create token header as a JSON string
		$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
		
		// Create token payload as a JSON string
		$payload = json_encode(['user_id' => $userID]);
		
		// Encode Header to Base64Url String
		$base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

		// Encode Payload to Base64Url String
		$base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

		// Create Signature Hash
		//https://www.php.net/manual/en/function.hash-hmac.php
		$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->key_hash_mac, true);
		
		// Encode Signature to Base64Url String
		$base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

		// Create JWT
		$jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

		
		return $jwt;
	}

	

	public function storeUserIDAndTokenRedis(string $userID,string $token): bool
	{
		try{
			//$this->redis->set('user:JWToken_'.$userID, $token, 'EX', $this->expirationTime_s); //35 seconds 30*60=1800
			Redis::set('user:JWToken_'.$userID, $token, 'EX', $this->expirationTime_s); //35 seconds 30*60=1800
			return True;
		}catch (Exception $e){
			return False;
		}
	}

	public function getJWTokenByUserID(string $userID): string | bool
	{
		try{
			$jwt = $this->redis->get('user:JWToken_'.$userID); //35 seconds 30*60=1800
			return $jwt;
		}catch (Exception $e){
			return False;
		}
	}
		
	
}

?>
