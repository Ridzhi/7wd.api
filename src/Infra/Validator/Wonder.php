<?php

namespace App\Infra\Validator;

use App\Domain\Game\Wonder\Id as Wid;
use Attribute;
use Symfony\Component\Validator\Constraints;

#[Attribute]
class Wonder extends Constraints\Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Constraints\NotBlank(message: 'wonder id is required'),
            new EnumType(type: Wid::class),
        ];
    }
}
