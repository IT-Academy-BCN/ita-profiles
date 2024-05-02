<?php 
// declare(strict_types=1);

namespace Service\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class userService
{
    use registerMessage;

    public function register($registerData):JsonResponse
    {
        // dd($registerData);

        // echo "estas en userService";

        $input = $registerData->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['email'] = $user->email;

        return $this->sendResponse($success, 'User registered successfully.');

    }
}