<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SigninTestSeeder extends Seeder
{	
	
	
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
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->usersRegistered as $newUser){
			
			$user = new User();
			$user->username = "";
			$user->email = $newUser['dni']."@mail.com";
			$user->dni = $newUser['dni'];
			$user->password = bcrypt($newUser['password']);
			$user->save();
		}
    }
}
