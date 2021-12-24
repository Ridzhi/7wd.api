<?php

namespace App\Infra\Validator;

use Attribute;
use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints;

#[Attribute]
class Email extends Compound
{
    /**
     * @inheritDoc
     */
    protected function getConstraints(array $options): array
    {
        return [
            new Constraints\NotBlank(message: "email is required"),
            new Constraints\Email(),
            new Constraints\Length(max: 40),
        ];
    }
}
