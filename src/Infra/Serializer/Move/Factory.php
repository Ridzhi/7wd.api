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
            new Normalizer\BurnCard(),
            new Normalizer\ConstructCard(),
            new Normalizer\ConstructWonder(),
            new Normalizer\DiscardCard(),
            new Normalizer\PickBoardToken(),
            new Normalizer\PickDiscardedCard(),
            new Normalizer\PickRandomToken(),
            new Normalizer\PickReturnedCards(),
            new Normalizer\PickTopLineCard(),
            new Normalizer\PickWonder(),
            new Normalizer\Prepare(),
            new Normalizer\SelectWhoStartsTheNextAge(),
        ]);
    }
}
