<?php
declare(strict_types=1);

namespace App\DTO;

class UserDTO
{
    public string $userID;
    public string $token;

    public function __construct(string $userID, string $token)
    {
        $this->userID = $userID;
        $this->token = $token;
    }
}

?>
