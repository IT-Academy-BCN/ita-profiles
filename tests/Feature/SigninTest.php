<?php
declare(strict_types=1);

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Depends;
//use Tests\TestCase;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//use Mockery;

//use PHPUnit\DbUnit\DataSet\MockDataSet;
//use PHPUnit\DbUnit\PHPUnit\Extensions\Database\DataSet\MockDataSet;


class SigninTest extends TestCase
{	
	use DatabaseTransactions;
	
	public static $users = array(
		array(
			'dni' => 'NODNI',
			'password' => 'passwordOne',
		),
		array( //Valid NIF and Password But Not Registered User - Pos 1
			'dni' => '78768396C',
			'password' => 'passOnePass',
		),
		array( //Valid NIE And Password But Not Registered User - Pos 2
			'dni' => 'Y3449747Z',
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
	
	public $usersRegistered = array(
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
    public function testSigninMockery($data, $expectedStatusCode)
    {
		
		// Build your mock object.
		$mockUser = Mockery::mock(User::class);

		// Have Laravel return the mocked object instead of the actual model.
		$this->app->instance('App\Models\User', $mockUser);
		
		foreach($this->usersRegistered as $newUser){
			
			$userData = [ 
				'name' => "",
				'surname' => "",
				'email' => $newUser['dni']."@mail.com",
				'dni' => $newUser['dni'],
				'password' => bcrypt($newUser['password']),
			];
			
			// Set up expectations for the model
			$mockUser->shouldReceive('create')->once()->andReturnUsing(function ($userData) {
				// Simulate inserting data into the model
				return new User($userData); // This could be more complex depending on your model
			});
			// Call the method that would use the User model to insert a new user
			$newUser = $mockUser->create($userData);
		}

		// Tell your mocked instance what methods it should receive.
		$mockUser
			->shouldReceive('checkUserCredentials')
			->shouldReceive('getUserIDByDNI');

		$response = $this->postJson('/api/v1/signin', $data);
		
		$response->assertStatus($expectedStatusCode);
        
    }
    
    
	/**
     * @dataProvider signinProvider
     *
     */     
    public function testSignin($data, $expectedStatusCode)
    {
		$response = $this->postJson('/api/v1/signin', $data);
		
		$response->assertStatus($expectedStatusCode);
	}
	
    static function signinProvider()
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

?>
