<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\User;

use Tests\TestCase;
use App\Models\User;
use App\Exceptions\UserNotFoundException;


class SigninTest extends TestCase
{	
	//Before running test the SigninTestSeeder class must be run!
	//php artisan db:seed --class=SigninTestSeeder
	
	/**
     * @dataProvider signinProvider
     *
     */     
    public function testSigninSuccess($data)
    {
		$response = $this->postJson('/api/v1/signin', $data);
		$response->assertStatus(200);
	}
	
    static function signinProvider(): array
    {
        $array = array(
			array(
				array( //Valid NIF and Password YES Registered User - Pos 5
					'dni' => '48332312C',
					'password' => 'passOnePass',
				)
				),
			array(
				array( //Valid NIE And Password YES Registered User - Pos 6
					'dni' => 'Y4527507V',
					'password' => 'passOnePass',
				)
				)
			);
		return $array;
    }
	
	
	/**
     * @dataProvider signinValidationErrorProvider
     *
     */     
    public function testSigninValidationError($data)
    {
		$response = $this->postJson('/api/v1/signin', $data);
		$response->assertStatus(422);
	}
	
    static function signinValidationErrorProvider(): array
    {
        $array = array(
			array(
				array(
					'dni' => 'NODNI',
					'password' => 'passwordOne',
				)
				),
			array(
				array( //Valid NIF and Wrong Password - Pos 3
					'dni' => '78768396C',
					'password' => '',
				)
				),
			array(
				array( //Valid NIE And Wrong Password - Pos 4
					'dni' => 'Y3449747Z',
					'password' => '',
				)
				)
			);
		return $array;
	}

	
	/**
     * @dataProvider signinNotUserFoundProvider
     *
     */     
    public function testSigninNotUserFound($data)
    {
		$response = $this->postJson('/api/v1/signin', $data);
		$response->assertStatus(401);
	}
	
    static function signinNotUserFoundProvider(): array
    {
        $array = array(
			array(
				array( //Valid NIF and Password But Not Registered User - Pos 1
					'dni' => '57792643Z',
					'password' => 'passOnePass',
				)
				),
			array(
				array( //Valid NIE And Password But Not Registered User - Pos 2
					'dni' => 'X2711281H',
					'password' => 'passOnePass',
				)
				)
			);
		return $array;
    }
	
	
}

