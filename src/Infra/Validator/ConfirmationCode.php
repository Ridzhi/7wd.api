<?php

namespace App\Infra\Validator;

use Attribute;
use Symfony\Component\Validator\Constraints;

#[Attribute]
class ConfirmationCode extends Constraints\Compound
{
    /**
     * @inheritDoc
     */
    protected function getConstraints(array $options): array
    {
        return [
            new Constraints\NotBlank(message: 'confirmation code is required'),
            new Constraints\Regex('/^[a-zA-Z0-9]{5,5}$/'),
        ];
    }
}
