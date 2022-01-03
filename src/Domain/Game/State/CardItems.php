<?php

namespace App\Domain\Game\State;

use App\Domain\Game\Card\Card;
use App\Domain\Game\Card\Id;

class CardItems
{
    public array $layout = [];

    /**
     * @var array<Id>
     */
    public array $playable = [];

    /**
     * @var array<Id>
     */
    public array $discarded = [];

    public function isPlayable(Id $card): bool
    {
        return in_array($card, $this->playable);
    }

    public function addToDiscard(Card $card): void
    {
        $this->discarded[] = $card->id;
    }

    public function removeFromDiscard(Card $card)
    {
        $pos = array_search($card->id, $this->discarded, true);

        if ($pos !== false) {
            unset($this->discarded[$pos]);
        }
    }
}
