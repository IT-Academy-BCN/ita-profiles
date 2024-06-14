<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Models\Resume;
use App\Models\Student;
use App\Models\User;
use Exception;
use PDOException;
use Error;

class UserRegisterService
{
    public function createUser(array $input): array
    {
        $input['password'] = bcrypt($input['password']);

        $user = $this->createUserRecord($input);
        // var_dump($user->id);exit;
        $student = $this->createStudentRecord($user->id);
        $this->createResumeRecord($student->id, $input['specialization'] ?? null);
        $success['token'] = $this->generateAccessToken($user);
        $success['email'] = $user->email;

        return $success;
    }

    private function createUserRecord(array $input): User
    {
        try {
            return User::create($input);
        } catch (PDOException $e) {
            throw new Exception('Error al crear el usuario en la base de datos: ' . $e->getMessage());
        } catch (Error $e) {
            throw new Exception('Error inesperado al crear el usuario: ' . $e->getMessage());
        }
    }

    private function createStudentRecord(string $userId): Student
    {
        try {
            $student = new Student;
            $student->user_id = $userId;
            $student->save();
            return $student;
        } catch (PDOException $e) {
            throw new Exception('Error al crear el estudiante en la base de datos: ' . $e->getMessage());
        } catch (Error $e) {
            throw new Exception('Error inesperado al crear el estudiante: ' . $e->getMessage());
        }
    }

    private function createResumeRecord(string $studentId, ?string $specialization): void
    {
        try {
            $resume = new Resume;
            $resume->student_id = $studentId;
            $resume->specialization = $specialization;
            $resume->save();
        } catch (PDOException $e) {
            throw new Exception('Error al crear el resume en la base de datos: ' . $e->getMessage());
        } catch (Error $e) {
            throw new Exception('Error inesperado al crear el resume: ' . $e->getMessage());
        }
    }

    private function generateAccessToken(User $user): string
    {
        try {
            return $user->createToken('ITAcademy')->accessToken;
        } catch (Exception $e) {
            throw new Exception('Error al generar el token de acceso: ' . $e->getMessage());
        }
    }
}
