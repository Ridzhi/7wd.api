<?php

namespace App\Adapter;

use App\Contract\ConfirmationCodeFactoryInterface;

class ConfirmationCodeFactory implements ConfirmationCodeFactoryInterface
{
    public function factory(int $size): string
    {
        $code = (string) random_int(0, (int) str_repeat("9", $size));

        return str_pad($code, $size,"0", STR_PAD_LEFT);
    }
}
