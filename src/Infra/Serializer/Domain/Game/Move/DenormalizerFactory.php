<?php

namespace App\Infra\Serializer\Domain\Game\Move;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Serializer;

class DenormalizerFactory
{
    public function factory(): DenormalizerInterface
    {
        return new Serializer([
            new BurnCardDenormalizer(),
            new ConstructCardDenormalizer(),
            new ConstructWonderDenormalizer(),
            new DiscardCardDenormalizer(),
            new OverDenormalizer(),
            new PickBoardTokenDenormalizer(),
            new PickDiscardedCardDenormalizer(),
            new PickRandomTokenDenormalizer(),
            new PickReturnedCardsDenormalizer(),
            new PickTopLineCardDenormalizer(),
            new PickWonderDenormalizer(),
            new PrepareDenormalizer(),
            new SelectWhoStartsTheNextAgeDenormalizer(),
        ]);
    }
}
