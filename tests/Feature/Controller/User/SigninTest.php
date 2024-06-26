<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\User;


use Tests\TestCase;
use App\Models\User;

/**
 * //@runTestsInSeparateProcesses
 * //@preserveGlobalState disabled
 */
//class SigninTestAux extends TestCase
class SigninTest extends TestCase
{	
	//Before running test the SigninTestSeeder class must be run!
	//php artisan db:seed --class=SigninTestSeeder
	//use DatabaseTransactions;

	public static array $users = array(
		array(
			'dni' => 'NODNI',
			'password' => 'passwordOne',
		),
		array( //Valid NIF and Password But Not Registered User - Pos 1
			'dni' => '57792643Z',
			'password' => 'passOnePass',
		),
		array( //Valid NIE And Password But Not Registered User - Pos 2
			'dni' => 'X2711281H',
			'password' => 'passOnePass',
		),
		array( //Valid NIF and Wrong Password - Pos 3
			'dni' => '78768396C',
			'password' => '',
		), 
		array( //Valid NIE And Wrong Password - Pos 4
			'dni' => 'Y3449747Z',
			'password' => '',
		),
		array( //Valid NIF and Password YES Registered User - Pos 5
			'dni' => '48332312C',
			'password' => 'passOnePass',
		),
		array( //Valid NIE And Password YES Registered User - Pos 6
			'dni' => 'Y4527507V',
			'password' => 'passOnePass',
		)
	);
	
	public array $usersRegistered = array(
		array( //Valid NIF and Password YES Registered User - Pos 5
			'dni' => '48332312C',
			'password' => 'passOnePass',
		),
		array( //Valid NIE And Password YES Registered User - Pos 6
			'dni' => 'Y4527507V',
			'password' => 'passOnePass',
		)
	);
	
    
	/**
     * @dataProvider signinProvider
     *
     */     
    public function testSignin($data, $expectedStatusCode)
    {
		$response = $this->postJson('/api/v1/signin', $data);
		
		$response->assertStatus($expectedStatusCode);
	}
	
    static function signinProvider(): array
    {
        $array = array(
			array(
				self::$users[0],
				422
				),
			array(
				self::$users[1],
				401
				),
			array(
				self::$users[2],
				401
				),
			array(
				self::$users[3],
				422
				),
			array(
				self::$users[4],
				422
				),
			array(
				self::$users[5],
				200
				),
			array(
				self::$users[6],
				200
				),
			
			);
		return $array;
    }
	
	
}

