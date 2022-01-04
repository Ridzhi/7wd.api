<?php

namespace App\Infra\Validator;

use App\Domain\Game\Card\Id as Cid;
use Attribute;
use Symfony\Component\Validator\Constraints;

#[Attribute]
class Card extends Constraints\Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Constraints\NotBlank(message: 'card id is required'),
            new EnumType(type: Cid::class),
        ];
    }
}
