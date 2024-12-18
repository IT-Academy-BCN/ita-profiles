<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Models\{
    Resume,
    Student,
    User,
};
use App\Exceptions\{
    UserRegisterException,
    ResumeCreateException,
    TokenGenerateException,
};
use Exception;
use PDOException;
use Error;

class UserRegisterService
{
    public function createUser(array $input): array
    {
        $input['password'] = bcrypt($input['password']);

        $user = $this->executeCreateUser($input);
        $student = $this->createStudentRecord($user->id, $input);
        $this->createResumeRecord($student->id, $input['specialization'] ?? null);
        $success['token'] = $this->generateAccessToken($user);
        $success['email'] = $user->email;

        return $success;
    }

    private function executeCreateUser(array $input): User
    {
        try {
            return $this->createUserRecord($input);
        } catch (PDOException | Error $e) {
            throw new Exception('Error creating user: ' . $e->getMessage(), 500);
        }
    }

    private function createUserRecord(array $input): User
    {
        try {
            foreach ($input as $key => $value) {
                if (empty($value)) {
                    throw new UserRegisterException("The field '$key' can't be empty.", $input);
                }
            }
            return User::create($input);
        } catch (PDOException | Error $e) {
            throw new UserRegisterException('Error creating user in database:' . $e->getMessage(), $input);
        }
    }

    private function createStudentRecord(string $userId, array $input): Student
    {
        try {
            $student = new Student;
            $student->user_id = $userId;
            $student->save();
            return $student;
        } catch (PDOException | Error $e) {
            throw new UserRegisterException('Error creating the student in the database: ' . $e->getMessage(), $input);
        }
    }

    private function createResumeRecord(string $studentId, ?string $specialization): void
    {
        try {
            $resume = new Resume;
            $resume->student_id = $studentId;
            $resume->specialization = $specialization;
            $resume->save();
        } catch (PDOException | Error $e) {
            throw new ResumeCreateException('Error creating summary:' . $e->getMessage());
        }
    }

    private function generateAccessToken(User $user): string
    {
        try {
            return $user->createToken('ITAcademy')->accessToken;
        } catch (Exception $e) {
            throw new TokenGenerateException('Error generating access token: ' . $e->getMessage());
        }
    }
}
