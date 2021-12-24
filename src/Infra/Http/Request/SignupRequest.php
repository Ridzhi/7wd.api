<?php

namespace App\Infra\Http\Request;

use Symfony\Component\Validator\Constraints;
use App\Infra\Validator as Check;

class SignupRequest
{
    #[Check\Email]
    private ?string $email;

    #[
        Constraints\NotBlank(message: 'password is required'),
        Constraints\Length(min: 6, max: 255),
    ]
    private ?string $password;

    #[Check\ConfirmationCode]
    private ?string $code;

    #[Check\Nickname]
    private ?string $nickname;

    public function __construct(array $params)
    {
        if (isset($params['email'])) {
            $this->email = strtolower($params['email']);
        }

        $this->password = $params['password'] ?? null;
        $this->code = $params['code'] ?? null;
        $this->nickname = $params['nickname'] ?? null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }
}
