<?php

namespace App\Domain\Game;

use App\Domain\Game\Card\Card;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Card\Repository;
use App\Domain\Game\Card\Type;

class Deck
{
    private const LAYOUT_SLOT_GUILD = -2;
    private const LAYOUT_SLOT_EMPTY = -1;
    private const LAYOUT_SLOT_FACE_DOWN = 0;

    /**
     * @var array<Cid>
     */
    private array $cards;

    private string $scheme;

    private array $graph = [];

    private array $faceDown = [];

    /**
     * @param array<Cid> $cards
     * @TODO replace to resolve method
     */
    public function __construct(array $cards)
    {
        $this->cards = $cards;
        $this->scheme = $this->getScheme();

        $prev = [];
        $curr = [];

        $rowPos = 0;
        $rowCount = 1;
        $cardPos = 0;

        foreach (str_split($this->scheme) as $char) {
            switch ($char) {
                case '\n':
                    foreach ($curr as $pos => $cid) {
                        $this->graph[$cid] = array_fill(0, 2, Cid::Null);

                        $right = $prev[$pos + 1];
                        $left = $prev[$pos - 1];

                        if ($right > 0) {
                            $this->graph[$right][0] = $cid;
                        }

                        if ($left > 0) {
                            $this->graph[$left][1] = $cid;
                        }
                    }

                    $rowPos = 0;
                    $rowCount++;
                    $prev = $curr;
                    $curr = [];

                    break;
                case '[':
                    if ($rowCount % 2 === 0) {
                        $this->faceDown[$cards[$cardPos]->value] = true;
                    }

                    $curr[$rowPos] = $cards[$cardPos];
                    $cardPos++;
                    $rowPos++;

                    break;
                default:
                    $rowPos++;
            }
        }
    }

    public function getLayout(): array
    {
        $layout = $this->cards;

        foreach ($this->cards as $pos => $cid) {
            if (!isset($this->graph[$cid->value])) {
                $layout[$pos] = self::LAYOUT_SLOT_EMPTY;
                continue;
            }

            if (isset($this->faceDown[$cid->value])) {
                $layout[$pos] = Repository::get($cid)->type === Type::Guild
                    ? self::LAYOUT_SLOT_GUILD
                    : self::LAYOUT_SLOT_FACE_DOWN;
            }
        }

        return $layout;
    }

    /**
     * @return array<int>
     */
    public function getPlayableCards(): array
    {
        return array_keys(
            array_filter(
                $this->graph,
                fn($children) => $children[0] === Cid::Null && $children[1] === Cid::Null,
            )
        );
    }

    public function getTopLineCards(): array
    {
        $count = substr_count(explode("\n", trim($this->scheme, "\n"))[0], '[');

        return array_filter(
            array_slice($this->getLayout(), 0, $count),
            fn($cid) => $cid > 0,
        );
    }

    public function getReturnedCards(): array
    {
        return array_diff(
            Repository::getByAge($this->getAge()),
            $this->cards,
        );
    }

    public function remove(Cid $card): void
    {
        unset($this->graph[$card->value]);

        array_walk($this->graph, function ($children, $parent) use ($card) {
            $del1 = false;
            $del2 = false;

            if ($children[0] === $card) {
                $children[0] = Cid::Null;
                $del1 = true;
            }

            if ($children[1] === $card) {
                $children[1] = Cid::Null;
                $del2 = true;
            }

            if ($del1 && $del2) {
                unset($this->faceDown[$parent]);
            }
        });
    }

    public function isEmpty(): bool
    {
        return count($this->graph);
    }

    private function getScheme(): string
    {
        return ltrim(match ($this->getAge()) {
            Age::I => <<<TPL
    [][]
   [][][]
  [][][][]
 [][][][][]
[][][][][][]
TPL,
            Age::II => <<<TPL
[][][][][][]
 [][][][][]
  [][][][]
   [][][]
    [][]
TPL,
            Age::III => <<<TPL
  [][]
 [][][]
[][][][]
 []  []
[][][][]
 [][][]
  [][]
TPL,
        });
    }

    private function getAge(): Age
    {
        return Repository::get($this->cards[0])->age;
    }
}
