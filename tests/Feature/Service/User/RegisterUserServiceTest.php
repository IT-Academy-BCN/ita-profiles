<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Service\User\UserRegisterService;

class RegisterUserServiceTest extends TestCase
{
    use DatabaseTransactions; //ensures that any database modifications made during testing are reverted once the test is complete

    protected $userService;
    
    protected $validationMessage = array ( 
		// username
		'username.required' => 'El username es requerido',
		'username.string' => 'El username debe ser un texto',
		'username.min' => 'El username debe tener al menos 3 caracteres',

		// dni
		'dni.required' => 'El dni es requerido',
		'dni.unique' => 'El dni ya existe',
		'dni.string' => 'El dni debe ser un texto',
		'dni.max' => 'El dni no debe ser mayor a :max caracteres',
		'dni.regex' => 'El dni no debe contener caracteres especiales',

		// email
		'email.required' => 'El email es requerido',
		'email.string' => 'El email debe ser un texto',
		'email.max' => 'El email no debe ser mayor a :max caracteres',
		'email.unique' => 'El email ya existe',

		// password
		'password.required' => 'La contraseña es requerida',
		'password.confirmed' => 'La confirmacion de la contraseña no coincide',
		'password.regex' => 'La contraseña debe contener al menos una mayúscula y un carácter especial, y tener una longitud minima de 8 caracteres',

		// specialization
		'specialization.required' => 'La especialidad es requerida',
		'specialization.in' => 'La especialidad no es valida',

		// terms
		'terms.required' => 'Debes aceptar los terminos y condiciones',
		'terms.in' => 'Debes aceptar los terminos y condiciones',

    );
    

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserRegisterService();
    }
		
		
		
    private function createUserData()
    {
        $userData['username'] = 'test_username';
        $userData['dni'] = '27827083G';
        $userData['email'] = 'test_email@test.com';
        $userData['terms'] = 'true';
        $userData['password'] = 'Password%123';
        $userData['specialization'] = 'Backend';
        $userData['password_confirmation'] = 'Password%123';

        return $userData;
    }

    public function test_user_creation_with_valid_data()
    {
        $userData = $this->createUserData();

        $request = new RegisterRequest($userData);

        $response = $this->userService->createUser($request);

        $this->assertEquals($userData['email'], $response['email']);
        $this->assertArrayHasKey('token', $response);
        $this->assertIsString($response['token']);
    }

    public function test_user_creation_with_invalid_data()
    {
        $registerData = new RegisterRequest([ 
            'username' => '',
            'dni' => 'invalidDNI',
            'specialization' => 'invalidSpecialization',  
            'terms' => 'false',          
            'email' => 'invalidemail',
            'password' => '123456'
        ]);

        //$this->expectException(Exception::class);
        
        $succes = $this->userService->createUser($registerData);
        
        //$this->assertEquals(True, empty($success['email']));
        $this->assertEquals(False, $succes);
        
    }

    public function test_user_creation_with_empty_data()
    {
        $registerData = new RegisterRequest([
            'username' => '',
            'dni' => '',
            'terms' => '',
            'specialization' => '',            
            'email' => '',
            'password' => ''
        ]);

        //$this->expectException(Exception::class);
        $this->userService->createUser($registerData);
        
        $succes = $this->userService->createUser($registerData);
        
        //$this->assertEquals(True, empty($success['email']));
        $this->assertEquals(False, $succes);
        
    }

    public function test_required_fields_for_user_creation()
    {
        // Missing 'username' field
        $registerData1 = new RegisterRequest([
            //'username' => 'test_username',
            'username' => '',
            'specialization' => 'Backend',
            'terms' => 'true',
            'email' => 'test@example.com',
            'password' => 'password123',
            'dni' => '27827083G'
        ]);

        $this->expectException(Exception::class);
        $this->userService->createUser($registerData1);


        // Missing 'email' field
        $registerData2 = new RegisterRequest([
            'username' => 'test_username',
            'specialization' => 'Backend',
            'terms' => 'true',
            'password' => 'password123',
            'dni' => '27827083G'
        ]);

        $this->expectException(Exception::class);
        $succes  = $this->userService->createUser($registerData1);
        
        // Missing 'password' field
        $registerData3 = new RegisterRequest([
            'username' => 'test_username',
            'specialization' => 'Backend',
            'terms' => 'true',
            'email' => 'janesmith@example.com',
            'dni' => '27827083G'
        ]);

        $this->expectException(Exception::class);
        $succes  = $this->userService->createUser($registerData1);
        
        // Missing 'dni' field
        $registerData4 = new RegisterRequest([
            'username' => 'test_username',
            'specialization' => 'Backend',
            'email' => 'alicebrown@example.com',
            'terms' => 'true',
            'password' => 'password123'
        ]);

        // Missing 'specialization' field
        $registerData4 = new RegisterRequest([
            'username' => 'Alice Brown',
            'dni' => '27827083G',
            'email' => 'alicebrown@example.com',
            'terms' => 'true',
            'password' => 'password123'
        ]);

        // Missing 'terms' field
        $registerData4 = new RegisterRequest([
            'username' => 'Alice Brown',
            'dni' => '27827083G',
            'email' => 'alicebrown@example.com',
            'specialization' => 'Backend',
            'password' => 'password123'
        ]);

        $this->expectException(Exception::class);
        $succes  = $this->userService->createUser($registerData1);
    }
    
    /**
     * @dataProvider required_fields_for_user_creation_provider 
     */
    public function test_required_fields_for_user_creation_my(array $array, bool $resultCorrect)
    {
        // Missing 'username' field
        $registerData = new RegisterRequest([
            //'username' => 'test_username',
            'username' => $array['username'] ?? "",
            'specialization' => $array['specialization'] ?? "",
            'terms' => $array['terms'] ?? "",
            'email' => $array['email'] ?? "",
            'password' => $array['password'] ?? "",
            'dni' => $array['dni'] ?? "",
        ]);

        //$this->expectException(Exception::class);
        //$this->userService->createUser($registerData1);
        $success  = $this->userService->createUser($registerData);
        //$this->assertEquals(False, $succes);
        //$this->assertEquals($this->validationMessage, $succes);
        
        if($resultCorrect){
			//$this->assertEquals($this->validationMessage, $succes);
			$this->assertEquals(True, empty($success['email']) == False && empty($success['token']) == False );
			
		}else{
			$this->assertEquals($resultCorrect, $success);
		}
        
	}
    
    static function required_fields_for_user_creation_provider()
    {
		$array = array(
			// Missing 'username' field - 0 
			array(
				array(
					//'username' => 'hoho',
					'specialization' => 'Backend',
					'terms' => 'true',
					'email' => 'test@example.com',
					'password' => 'password123',
					'dni' => '27827083G'
				),
				True
			),
			// Missing 'email' field - 1
			array(
				array(		
					'username' => 'test_username',
					'specialization' => 'Backend',
					'terms' => 'true',
					'password' => 'password123',
					'dni' => '27827083G',
					//'email' => 'test@example.com',
				),
				//Returning False because email is not specified
				False
			),
			// Missing 'password' field  - 2
			array(
				array(		
					'username' => 'test_username',
					'specialization' => 'Backend',
					'terms' => 'true',
					'email' => 'janesmith@example.com',
					'dni' => '27827083G'
				),
				True
			),
			
			//// Missing 'dni' field  - 3
			array(
				array(		
					'username' => 'test_username',
					'specialization' => 'Backend',
					'email' => 'alicebrown@example.com',
					'terms' => 'true',
					'password' => 'password123'
				),
				True
			),
			// Missing 'specialization' field - 4
			array(
				array(		
					'username' => 'Alice Brown',
					'dni' => '27827083G',
					'email' => 'alicebrown@example.com',
					'terms' => 'true',
					'password' => 'password123'
				),
				//False because "specialization" not in DB ENUM
				False
			),
			
			// Missing 'terms' field - 5
			array(
				array(		
					'username' => 'Alice Brown',
					'dni' => '27827083G',
					'email' => 'alicebrown@example.com',
					'specialization' => 'Backend',
					'password' => 'password123'
				),
				True
			),
			
			
		);
		
		return $array;
	}
    
    
    
}



