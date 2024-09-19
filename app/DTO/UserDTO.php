<?php
declare(strict_types=1);

namespace App\DTO;

class UserDTO
{
    public string $userID;
    public ?string $studentID; // ? is because studentID can be null
    public string $token;

    public function __construct(string $userID, ?string $studentID = null, string $token)
    {
        $this->userID = $userID;
        $this->studentID = $studentID;
        $this->token = $token;
    }
}

?>
