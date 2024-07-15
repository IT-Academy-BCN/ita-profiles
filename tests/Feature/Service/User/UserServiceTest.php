<?php

declare(strict_types=1);


namespace Tests\Feature\Service\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

use App\Service\User\UserService;

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
	public function testCheckUserCredentialsSuccess(string $userDNI, string $password, bool $correctPasswordBool, bool $expectedOutput)
	{
		$user = User::factory()->create(['dni' => $userDNI, 'password' => ($correctPasswordBool ? bcrypt($password) : bcrypt('WrongPassword'))]);
		$user->save();

		$result = $this->service->checkUserCredentials($user, $password);

		$this->assertEquals($expectedOutput, $result);
	}

	static function checkUserCredentialsSuccessProvider(): array
	{
		$array = array(
			array(
				'69818630Z',
				'password',
				true, // Correct Password bool
				true // Expected Output
			),
			array(
				'X6849947H',
				'password',
				true, // Correct Password bool
				true // Expected Output
			),
			array(
				'48332312C',
				'passOnePass',
				true, // Correct Password bool
				true // Expected Output
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
		$user = User::factory()->create(['dni' => $userDNI,  'password' => bcrypt('WrongPassword')]);
		$user->save();

		$result = $this->service->checkUserCredentials($user, $password);

		$this->assertEquals(false, $result);
	}

	static function checkUserCredentialsFailurePasswordProvider(): array
	{
		$array = array(
			array(
				'69818630Z', //NIF/NIE
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
		$user->save();
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
				'69818630Z' //NIF/NIE
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
		$user->save();

		$jwt = $this->service->generateJWToken($user);
		$resultOne = preg_match('(^[\w-]*\.[\w-]*\.[\w-]*$)', $jwt); //(^[\w-]*\.[\w-]*\.[\w-]*$)
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
				'abc',
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
		$result = $this->service->getJWTokenByUserID($userID);
		$this->assertEquals($result, $expectedOutput);
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
	public function testGetJWTokenByUserIDFailure(string $userID, bool $expectedOutput)
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
				false // Expected Output
			)
		);

		return $array;
	}


	protected function tearDown(): void
	{
		parent::tearDown();
	}
}
