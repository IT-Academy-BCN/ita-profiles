<?php

declare(strict_types=1);

namespace Tests\Feature\Service\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

use App\Service\User\UserService;

use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserNotFoundInRedisException;

class UserServiceTest extends TestCase
{
	use DatabaseTransactions;
	private $service;

	public function setUp(): void
	{
		parent::setUp();
		$this->service = new UserService();
	}

	/**
	 * @dataProvider checkUserCredentialsSuccessProvider
	 *
	 */
	public function testCheckUserCredentialsSuccess(string $userDNI, string $password)
	{
		$user = User::factory()->create(['dni' => $userDNI, 'password' => bcrypt($password)]);

		$result = $this->service->checkUserCredentials($user, $password);

		$this->assertEquals(true, $result);
	}

	static function checkUserCredentialsSuccessProvider(): array
	{
		$array = array(
			array(
				'69818630Z',
				'password'
			),
			array(
				'X6849947H',
				'password'
			),
			array(
				'48332312C',
				'passOnePass'
			)
		);
		return $array;
	}

	/**
	 * @dataProvider checkUserCredentialsFailurePasswordProvider
	 *
	 */
	public function testCheckUserCredentialsFailurePassword(string $userDNI, string $password)
	{
		$this->expectException(InvalidCredentialsException::class);

		$user = User::factory()->create(['dni' => $userDNI, 'password' => bcrypt('WrongPassword')]);

		$this->service->checkUserCredentials($user, $password);
	}

	static function checkUserCredentialsFailurePasswordProvider(): array
	{
		$array = array(
			array(
				'69818630Z',
				'password'
			),
			array(
				'X6849947H',
				'password'
			),
		);
		return $array;
	}


	/**
	 * @dataProvider getUserByDNISuccessProvider
	 */
	public function testGetUserByDNI(string $userDNI)
	{
		$user = User::factory()->create(['dni' => $userDNI]);

		$user->refresh();

		$user_return = $this->service->getUserByDNI($userDNI);
		$user_refreshed = User::where('dni', $user->dni)->first();
		$this->assertEquals($user_refreshed->getAttributes(), $user_return->getAttributes());
		$this->assertEquals($user->getAttributes(), $user_return->getAttributes());
	}

	static function getUserByDNISuccessProvider()
	{
		$array = array(
			array(
				'69818630Z'
			),
		);

		return $array;
	}

	/**
	 * @dataProvider getUserByDNIUserNotFoundProvider
	 */
	public function testGetUserByDNIUserNotFound(string $userDNI)
	{
		$this->expectException(UserNotFoundException::class);

		$this->service->getUserByDNI($userDNI);
	}

	static function getUserByDNIUserNotFoundProvider()
	{
		$array = array(
			array(
				'95499409M'
			),
		);

		return $array;
	}


	/**
	 * @dataProvider generateJWTokenProvider
	 */
	public function testGenerateJWToken()
	{
		$user = User::factory()->create();

		$jwt = $this->service->generateJWToken($user);
		$resultOne = preg_match('(^[\w-]*\.[\w-]*\.[\w-]*$)', $jwt);
		$resultTwo = preg_match('(^[A-Za-z0-9-_]*\.[A-Za-z0-9-_]*\.[A-Za-z0-9-_]*$)', $jwt);

		$this->assertEquals($resultOne, true);
		$this->assertEquals($resultTwo, true);
	}


	static function generateJWTokenProvider()
	{
		return [
			['123', true],
			['abc', false],
			[123, true],
			[021, true],
		];
	}


	/**
	 * @dataProvider storeUserIDAndTokenRedisProvider
	 */
	public function testStoreUserIDAndTokenRedis(string $userID, string $jwt, bool $expectedOutput)
	{
		//ToDo - Important - Hide Connection And Check Redis Network Communication
		//ToDo - Or just use a testing database
		$result = $this->service->storeUserIDAndTokenRedis($userID, $jwt);
		$this->assertEquals($result, $expectedOutput);
	}
	
	static function storeUserIDAndTokenRedisProvider()
	{
		$array = array(
			array(
				'Z123', //userID
				'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c',
				true // Expected Output
			),
			array(
				'abc', //userID
				'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJjbGllbnRfaWQiOiJZekV6TUdkb01ISm5PSEJpT0cxaWJEaHlOVEE9IiwicmVzcG9uc2VfdHlwZSI6ImNvZGUiLCJzY29wZSI6ImludHJvc2NwZWN0X3Rva2VucywgcmV2b2tlX3Rva2VucyIsImlzcyI6ImJqaElSak0xY1hwYWEyMXpkV3RJU25wNmVqbE1iazQ0YlRsTlpqazNkWEU9Iiwic3ViIjoiWXpFek1HZG9NSEpuT0hCaU9HMWliRGh5TlRBPSIsImF1ZCI6Imh0dHBzOi8vbG9jYWxob3N0Ojg0NDMve3RpZH0ve2FpZH0vb2F1dGgyL2F1dGhvcml6ZSIsImp0aSI6IjE1MTYyMzkwMjIiLCJleHAiOiIyMDIxLTA1LTE3VDA3OjA5OjQ4LjAwMCswNTQ1In0.IxvaN4ER-PlPgLYzfRhk_JiY4VAow3GNjaK5rYCINFsEPa7VaYnRsaCmQVq8CTgddihEPPXet2laH8_c3WqxY4AeZO5eljwSCobCHzxYdOoFKbpNXIm7dqHg_5xpQz-YBJMiDM1ILOEsER8ADyF4NC2sN0K_0t6xZLSAQIRrHvpGOrtYr5E-SllTWHWPmqCkX2BUZxoYNK2FWgQZpuUOD55HfsvFXNVQa_5TFRDibi9LsT7Sd_az0iGB0TfAb0v3ZR0qnmgyp5pTeIeU5UqhtbgU9RnUCVmGIK-SZYNvrlXgv9hiKAZGhLgeI8hO40utfT2YTYHgD2Aiufqo3RIbJA',
				true // Expected Output
			),
		);

		return $array;
	}

	/**
	 * @dataProvider getJWTokenByUserIDProvider
	 */
	public function testGetJWTokenByUserIDSuccess(string $userID, bool $expectedOutput)
	{
		//ToDo - Important - Hide Connection And Check Redis Network Communication
		//ToDo - Or just use a testing database

		$jwt = $this->service->getJWTokenByUserID($userID);
		$resultOne = preg_match('(^[\w-]*\.[\w-]*\.[\w-]*$)', $jwt); //(^[\w-]*\.[\w-]*\.[\w-]*$)
		$resultTwo = preg_match('(^[A-Za-z0-9-_]*\.[A-Za-z0-9-_]*\.[A-Za-z0-9-_]*$)', $jwt);

		$this->assertEquals($resultOne, true);
		$this->assertEquals($resultTwo, true);
	}
	static function getJWTokenByUserIDProvider()
	{
		$array = array(
			array(
				'Z123', //userID
				true // Expected Output
			),
			array(
				'abc', //userID
				true // Expected Output
			)
		);

		return $array;
	}


	/**
	 * @dataProvider getJWTokenByUserIDFailureProvider
	 */
	public function testGetJWTokenByUserIDFailure(string $userID)
	{
		//ToDo - Important - Hide Connection And Check Redis Network Communication
		//ToDo - Or just use a testing database
		$this->expectException(UserNotFoundInRedisException::class);
		$result = $this->service->getJWTokenByUserID($userID);
	}
	static function getJWTokenByUserIDFailureProvider()
	{
		$array = array(
			array(
				'ZZZZZZZZZ981273', //userID
			)
		);

		return $array;
	}


	protected function tearDown(): void
	{
		parent::tearDown();
	}
}
