<?php

namespace App\Adapter;

use App\Contract\UuidFactoryInterface;
use Symfony\Component\Uid\Uuid;

class UuidFactory implements UuidFactoryInterface
{
    public function v4(): string
    {
        return Uuid::v4();
    }
}
