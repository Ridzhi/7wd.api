<?php

namespace App\Infra\Validator;

use App\Domain\Game\Token\Id as Tid;
use Attribute;
use Symfony\Component\Validator\Constraints;

#[Attribute]
class Token extends Constraints\Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Constraints\NotBlank(message: 'token id is required'),
            new EnumType(type: Tid::class),
        ];
    }
}
