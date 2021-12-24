<?php

namespace App\Infra\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class Nickname extends Constraint
{
    public string $invalidLength = 'nickname "{{ value }}" has invalid length, expected "{{ length }}"';
    public string $invalidFormat = 'nickname "{{ value }}" has invalid format';

    /**
     * @inheritDoc
     */
    public function validatedBy(): string
    {
        return NicknameValidator::class;
    }
}
