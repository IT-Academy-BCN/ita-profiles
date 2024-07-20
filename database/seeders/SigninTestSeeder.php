<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

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
		$userIds = [];
		foreach ($this->usersRegistered as $newUser) {
			$user = new User();
			$user->username = "";
			$user->email = $newUser['dni'] . "@mail.com";
			$user->dni = $newUser['dni'];
			$user->password = bcrypt($newUser['password']);
			$user->save();
			$userIds[] = $user->id; // Create an array of the user ID to save it cache.
		}
		// Store user IDs in cache for later retrieval (used it in the ResumeFactory to create students with user IDs)
		Cache::put('test_user_ids', $userIds, 3600); // 1 hour
	}
}
