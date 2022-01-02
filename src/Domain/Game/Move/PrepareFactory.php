<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\Age;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Card\Repository as CardRepository;
use App\Domain\Game\Rule;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Token\Repository as TokenRepository;
use App\Domain\Game\Wonder\Id as Wid;
use App\Domain\Game\Wonder\Repository as WonderRepository;

class PrepareFactory
{
    public function factory(string $p1, string $p2): Prepare
    {
        list($p1, $p2) = $this->shufflePlayers($p1, $p2);
        $tokens = $this->getTokens();

        return new Prepare(
            p1: $p1,
            p2: $p2,
            wonders: array_slice($this->getWonders(), 0, Rule::WONDERS_POOL_SIZE * 2),
            tokens: array_slice($tokens, 0, Rule::BOARD_TOKENS_COUNT),
            randomTokens: array_slice($tokens, -Rule::RANDOM_TOKENS_COUNT),
            cards: [
                Age::I->value => $this->getCards(Age::I),
                Age::II->value => $this->getCards(Age::II),
                Age::III->value => $this->getCards(Age::III),
            ],
        );
    }

    private function shufflePlayers(string $p1, string $p2): array
    {
        if (rand(0, 1)) {
            list($p2, $p1) = [$p1, $p2];
        }

        return [$p1, $p2];
    }

    /**
     * @return array<Tid>
     */
    private function getTokens(): array
    {
        /** @uses \App\Domain\Game\Token\Token::$id */
        $tokens = array_column(TokenRepository::getAll(), 'id');
        shuffle($tokens);

        return $tokens;
    }

    /**
     * @return array<Wid>
     */
    private function getWonders(): array
    {
        /** @uses \App\Domain\Game\Wonder\Wonder::$id */
        $wonders = array_column(WonderRepository::getAll(), 'id');
        shuffle($wonders);

        return $wonders;
    }

    /**
     * @return array<Cid>
     */
    private function getCards(Age $age): array
    {
        $cards = CardRepository::getByAge($age);
        shuffle($cards);

        switch ($age) {
            case Age::III:
                $cards = array_slice($cards, 0, Rule::DECK_LIMIT - Rule::GUILDS_LIMIT);
                $guilds = CardRepository::getGuilds();
                shuffle($guilds);
                array_push($cards, ...array_slice($guilds, 0, Rule::DECK_LIMIT));
                shuffle($cards);
                break;
            default:
                $cards = array_slice($cards, 0, Rule::DECK_LIMIT);
        }

        return $cards;
    }
}
