<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\ActionInterface;
use App\Domain\Game\Card\Id as CardId;

class ConstructCard implements ActionInterface
{
    public Id $id = Id::ConstructCard;
    public CardId $card;

    public function __construct(CardId $card)
    {
        $this->card = $card;
    }

    public function update(): void
    {
        $a = $this->card;
    }
}
