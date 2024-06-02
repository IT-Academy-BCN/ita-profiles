<?php

declare(strict_types=1);

namespace Service\User;

use App\Models\Resume;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;
use PDOException;

class UserRegisterService
{
    public function createUser(array $input): array | bool
    {
        if (empty($input['email']) || empty($input['password'])) {
            return false;
        }

        $input['password'] = bcrypt($input['password']);

        DB::beginTransaction();

        try {
            $user = User::create($input);

            $student = new Student;
            $student->user_id = $user->id;
            $student->save();

            $resume = new Resume;
            $resume->student_id = $student->id;
            $resume->specialization = $input['specialization'] ?? null;
            $resume->save();

            $success['token'] = $user->createToken('ITAcademy')->accessToken;

            DB::commit();

            $success['email'] = $user->email;
            return $success;
        } catch (PDOException | Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
