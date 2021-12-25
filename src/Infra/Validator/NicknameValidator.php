<?php

namespace App\Infra\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class NicknameValidator extends ConstraintValidator
{
    public const MIN_LENGTH = 3;
    public const MAX_LENGTH = 15;

    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Nickname) {
            throw new UnexpectedTypeException($constraint, Nickname::class);
        }

        if ($value === null || $value === '') {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $length = strlen($value);

        if ($length < self::MIN_LENGTH || $length > self::MAX_LENGTH) {
            $this
                ->context
                ->buildViolation($constraint->invalidLength)
                ->setParameter('{{ value }}', $value)
                ->setParameter('{{ length }}', sprintf("%d - %d", self::MIN_LENGTH, self::MAX_LENGTH))
                ->addViolation();
        }

        if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9]*$/', $value, $matches)) {
            $this
                ->context
                ->buildViolation($constraint->invalidFormat)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
