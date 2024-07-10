<?php

declare(strict_types=1);


namespace Tests\Feature\Service\User;

use Tests\TestCase;
use App\Models\User;

use App\Service\User\UserService;

use Mockery;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class UserServiceTest extends TestCase
{
	private $service;
	public $mockery;

	public function setUp(): void
	{
		parent::setUp();
		$this->service = new UserService();
		$this->mockery = Mockery::mock('overload:App\Models\User');
	}

	/**
	 * @dataProvider checkUserCredentialsProvider
	 *
	 */
	public function testCheckUserCredentials(string $userDNI, string $password, bool $correctPasswordBool, bool $addDBBool, bool $expectedOutput)
	{
		$randID = rand(1, 100);

		if ($addDBBool == True) {
			$returnUser = new User;
			$returnUser->id = intval($randID);
			$returnUser->username = "Surname";
			$returnUser->email = $userDNI . "@mail.com";
			$returnUser->dni = $userDNI;
			$returnUser->password = ($correctPasswordBool ? bcrypt($password) : bcrypt('WrongPassword'));
		} else {
			$returnUser = Null;
		}

		// I think this is not necessary if we use the model in the function instead of a DNI.
		// $returnCollection = collect([$returnUser]);

		// $this->mockery->shouldReceive('where')
		// 	->with('dni', $userDNI)
		// 	->andReturn($returnCollection);

		// $this->app->instance('overload:App\Models\User', $this->mockery);

		//Perform the call to the function to be tested, checking first if returnUser is not null:
		$result = false;
		if ($returnUser !== null) {
			$result = $this->service->checkUserCredentials($returnUser, $password);
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
	 * @dataProvider getUserIDByDNIProvider
	 */
	public function testGetUserIDByDNI(string $userDNI, bool $addDBBool, bool $expectedOutput)
	{

		$randID = rand(1, 100);
		if ($addDBBool == True) {

			$returnUser = new User;

			$returnUser->id = intval($randID);
			$returnUser->username = "";
			$returnUser->email = $userDNI . "@mail.com";
			$returnUser->dni = $userDNI;
			$returnUser->password = bcrypt("password");
		} else {
			$returnUser = False;
		}

		$returnCollection = collect([$returnUser]);

		$this->mockery->shouldReceive('where')
			->with('dni', $userDNI)
			->andReturn($returnCollection);

		$id = $this->service->getUserIDByDNI($userDNI);

		//Assert Result
		if ($expectedOutput == False) {
			$this->assertEquals(False, $id);
		} else {
			$this->assertEquals($randID, $id);
		}
	}


	static function getUserIDByDNIProvider()
	{
		$array = array(
			array(
				'69818630Z', //NIF/NIE
				True, //Add In "DB" (True = Yes , False = No)
				True // Expected Output
			),
			array(
				'69818630Z', //NIF/NIE
				False, //Add In "DB" (True = Yes , False = No)
				False // Expected Output
			),
		);

		return $array;
	}


	/**
	 * @dataProvider generateJWTokenProvider
	 */
	public function testGenerateJWToken(string | int $userID, bool $expectedOutput)
	{
		$jwt = $this->service->generateJWToken($userID);
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
		// $array = array(
		// 	array(
		// 		'123', //userID
		// 		True // Expected Output
		// 	),
		// 	array(
		// 		'abc', //userID
		// 		False // Expected Output
		// 	),
		// 	array(
		// 		123, //userID
		// 		True // Expected Output
		// 	),
		// 	array(
		// 		021, //userID
		// 		True // Expected Output
		// 	),
		// );

		// return $array;

		// IS THIS THE SAME AS ABOVE??
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
	public function testGetJWTokenByUserID(string $userID, bool $expectedOutput)
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
			),
			array(
				'ZZZZZZZZZ981273', //userID
				False // Expected Output
			),
		);

		return $array;
	}


	protected function tearDown(): void
	{
		parent::tearDown();
		\Mockery::close(); // Clean up Mockery
	}
}
