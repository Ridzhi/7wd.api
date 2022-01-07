<?php

namespace App\Domain\Game\State;

use App\Domain\Game\Game;
use App\Domain\Game\Move\Id;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Factory
{
    public function __construct(
        private DenormalizerInterface $moveDenormalizer,
    )
    {
    }

    public function factory(Game $game): State
    {
        $moves = array_map(
            fn($move) => $this
                ->moveDenormalizer
                ->denormalize(
                    $move,
                    Id::from($move['id'])->classname(),
                ),
            $game->getMoves(),
        );

        $state = new State();

        foreach ($moves as $move) {
            $move->mutate($state);
        }

        return $state;
    }
}
