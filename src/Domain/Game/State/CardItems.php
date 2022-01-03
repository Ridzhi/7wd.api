<?php

namespace App\Domain\Game\State;

use App\Domain\Game\Card\Id as Cid;

class CardItems
{
    public array $layout = [];

    /**
     * @var array<Cid>
     */
    public array $playable = [];

    /**
     * @var array<Cid>
     */
    public array $discarded = [];

    public function isPlayable(Cid $card): bool
    {
        return in_array($card, $this->playable);
    }

    public function addToDiscard(Cid $card): void
    {
        $this->discarded[] = $card;
    }

    public function removeFromDiscard(Cid $card)
    {
        $pos = array_search($card, $this->discarded, true);

        if ($pos !== false) {
            unset($this->discarded[$pos]);
        }
    }
}
