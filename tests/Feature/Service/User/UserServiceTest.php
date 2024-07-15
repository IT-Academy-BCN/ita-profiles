<?php

declare(strict_types=1);


namespace Tests\Feature\Service\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

use App\Service\User\UserService;

use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserNotFoundInRedisException;
use App\Exceptions\UserNotStoredInRedisException;
use App\Exceptions\CouldNotCreateJWTokenPassportException;

use Illuminate\Support\Facades\DB;



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
	 * @dataProvider checkUserCredentialsProvider
	 *
	 */
	public function testCheckUserCredentials(string $userDNI, string $password, bool $correctPasswordBool, bool $addDBBool, bool $expectedOutput)
	{
		$randID = rand(1, 100);
		$user = User::factory()->create(['id' => $randID, 'dni' => $userDNI,  'password' => ($correctPasswordBool ? bcrypt($password) : bcrypt('WrongPassword'))]);
		$user ->save();

		//Perform the call to the function to be tested, checking first if returnUser is not null:
		$result = false;
		if ($user !== null) {
			$result = $this->service->checkUserCredentials($user, $password);
		}

		//Assert Result
		$this->assertEquals($expectedOutput, $result);
	}
	
	static function checkUserCredentialsProvider(): array
	{
		$array = array(
			array(
				'69818630Z', //NIF/NIE
				'password', //Password
				False, //Add In "DB" With True/False Password
				False, //Add In "DB" (True = Yes , False = No)
				False // Expected Output
			),
			array(
				'X6849947H',
				'password',
				False, //Add In "DB" With True/False Password
				False, //Add In "DB" (True = Yes , False = No)
				False // Expected Output
			),
			array(
				'69818630Z',
				'password',
				True, //Add In "DB" With True/False Password
				True, //Add In "DB" (True = Yes , False = No)
				True // Expected Output
			),
			array(
				'X6849947H',
				'password',
				True, //Add In "DB" With True/False Password
				True, //Add In "DB" (True = Yes , False = No)
				True // Expected Output
			),
			array(
				'69818630Z',
				'password',
				False, //Add In "DB" With True/False Password
				True, //Add In "DB" (True = Yes , False = No)
				False // Expected Output
			),
			array(
				'X6849947H',
				'password',
				False, //Add In "DB" With True/False Password
				True,  //Add In "DB" (True = Yes , False = No)
				False // Expected Output
			),
			array(
				'48332312C',
				'passOnePass',
				True, //Add In "DB" With True/False Password
				True,  //Add In "DB" (True = Yes , False = No)
				True // Expected Output
			),
		);
		return $array;
	}
	
	
	
		/**
	 * @dataProvider checkUserCredentialsProvider
	 *
	 */
	public function testCheckUserCredentialsSuccess(string $userDNI, string $password, bool $correctPasswordBool, bool $addDBBool, bool $expectedOutput)
	{
		$randID = rand(1, 100);
		$user = User::factory()->create(['id' => $randID, 'dni' => $userDNI,  'password' => ($correctPasswordBool ? bcrypt($password) : bcrypt('WrongPassword'))]);
		$user ->save();

		//Perform the call to the function to be tested, checking first if returnUser is not null:
		$result = $this->service->checkUserCredentials($user, $password);


		//Assert Result
		$this->assertEquals($expectedOutput, $result);
	}
	
	static function checkUserCredentialsSuccessProvider(): array
	{
		$array = array(
			array(
				'69818630Z',
				'password',
				True, //Add In "DB" With True/False Password
				True, //Add In "DB" (True = Yes , False = No)
				True // Expected Output
			),
			array(
				'X6849947H',
				'password',
				True, //Add In "DB" With True/False Password
				True, //Add In "DB" (True = Yes , False = No)
				True // Expected Output
			),
			array(
				'48332312C',
				'passOnePass',
				True, //Add In "DB" With True/False Password
				True,  //Add In "DB" (True = Yes , False = No)
				True // Expected Output
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
		$randID = rand(1, 100);
		$user = User::factory()->create(['id' => $randID, 'dni' => $userDNI,  'password' => bcrypt('WrongPassword') ]);
		$user->save();

		//Perform the call to the function to be tested, checking first if returnUser is not null:
		$result = $this->service->checkUserCredentials($user, $password);


		//Assert Result
		$this->assertEquals(False, $result);
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
		$user_refreshed = User::where('dni',$user->dni)->first();
		$this->assertEquals($user_refreshed->getAttributes(), $user_return->getAttributes());

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
		
		$user_return = $this->service->getUserByDNI($userDNI);
	
		$this->assertEquals($user, $user_return);

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
	public function testGenerateJWToken(string | int $userID, bool $expectedOutput)
	{
		
		$user = \App\Models\User::factory()->create(['id' => '1']);
		$user->save();
		
		$jwt = $this->service->generateJWToken($user);
		$resultOne = preg_match('(^[\w-]*\.[\w-]*\.[\w-]*$)', $jwt); //(^[\w-]*\.[\w-]*\.[\w-]*$)
		$resultTwo = preg_match('(^[A-Za-z0-9-_]*\.[A-Za-z0-9-_]*\.[A-Za-z0-9-_]*$)', $jwt);

		if ($resultOne == true && $resultTwo == true) {
			// shouldn't this check use $expectedOutput instead of true?
			$this->assertEquals(true, true);
		} else {
			$this->assertEquals(true, false);
		}
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
				True // Expected Output
			),
			array(
				'abc', //userID
				'abc',
				True // Expected Output
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
				True // Expected Output
			),
			array(
				'abc', //userID
				True // Expected Output
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
				False // Expected Output
			)
		);

		return $array;
	}
	


	protected function tearDown(): void
	{
		parent::tearDown();
	}
}
