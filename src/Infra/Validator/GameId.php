<?php

namespace App\Infra\Validator;

use Attribute;
use Symfony\Component\Validator\Constraints;

#[Attribute]
class GameId extends Constraints\Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Constraints\NotBlank(message: 'game id is required'),
            new Constraints\Positive(),
        ];
    }
}
