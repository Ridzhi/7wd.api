<?php

namespace App\Contract;

interface ConfirmationCodeFactoryInterface
{
    public function factory(int $size): string;
}
