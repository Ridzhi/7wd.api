<?php

namespace App\Infra\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class EnumType extends Constraint
{
    /**
     * @param class-string $type
     */
    public function __construct(
        public string $type,
    )
    {
        parent::__construct();
    }

    public function validatedBy(): string
    {
        return EnumTypeValidator::class;
    }
}
