<?php

namespace App\Infra\Serializer\Move;

use App\Infra\Serializer\Move\Normalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Serializer;

class Factory
{
    public function factory(): DenormalizerInterface
    {
        return new Serializer([
            new Normalizer\Prepare(),
        ]);
    }
}