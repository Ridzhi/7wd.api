<?php

namespace App\Contract;

interface JwtEncoderInterface
{
    public function encode(array $payload): string;
}
