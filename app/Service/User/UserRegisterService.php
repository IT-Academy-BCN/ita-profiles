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
        // Verifica que los campos de email y password no estén vacíos
        if (empty($input['email']) || empty($input['password'])) {
            return false;
        }

        // Hashea la contraseña
        $input['password'] = bcrypt($input['password']);

        DB::beginTransaction();

        try {
            // Crea el usuario
            $user = User::create($input);

            // Crea el estudiante asociado al usuario
            $student = new Student;
            $student->user_id = $user->id;
            $student->save();

            // Crea el currículum asociado al estudiante
            $resume = new Resume;
            $resume->student_id = $student->id;
            $resume->specialization = $input['specialization'] ?? null;
            $resume->save();

            // Genera el token de acceso
            $success['token'] = $user->createToken('ITAcademy')->accessToken;

            DB::commit();

            $success['email'] = $user->email;
            // Devuelve el email del usuario y el token
            return $success;
        } catch (PDOException | Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
