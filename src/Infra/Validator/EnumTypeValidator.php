<?php

namespace App\Infra\Validator;

use BackedEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class EnumTypeValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof EnumType) {
            throw new UnexpectedTypeException($constraint, EnumType::class);
        }

        if ($value === null || $value === '') {
            return;
        }

        /** @var BackedEnum|string $classname */
        $classname = $constraint->type;

        $classname::tryFrom($value)
        ?? throw new UnexpectedValueException($value, $classname);
    }
}
