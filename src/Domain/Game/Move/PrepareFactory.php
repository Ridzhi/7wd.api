<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\Age;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Card\Repository as CardRepository;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Token\Repository as TokenRepository;
use App\Domain\Game\Wonder\Id as Wid;
use App\Domain\Game\Wonder\Repository as WonderRepository;

class PrepareFactory
{
    private const BOARD_TOKENS_COUNT = 5;
    private const RANDOM_TOKENS_COUNT = 3;
    private const WONDERS_POOL_SIZE = 4;
    private const DECK_LIMIT = 20;
    private const GUILDS_LIMIT = 3;

    public function __construct(
        private WonderRepository $wonderRepository,
        private TokenRepository  $tokenRepository,
        private CardRepository   $cardRepository,
    )
    {
    }

    public function factory(string $p1, string $p2): Prepare
    {
        list($p1, $p2) = $this->shufflePlayers($p1, $p2);
        $tokens = $this->getTokens();

        return new Prepare(
            p1: $p1,
            p2: $p2,
            wonders: array_slice($this->getWonders(), 0, self::WONDERS_POOL_SIZE * 2),
            tokens: array_slice($tokens, 0, self::BOARD_TOKENS_COUNT),
            randomTokens: array_slice($tokens, -self::RANDOM_TOKENS_COUNT),
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
        $tokens = array_column($this->tokenRepository->data, 'id');
        shuffle($tokens);

        return $tokens;
    }

    /**
     * @return array<Wid>
     */
    private function getWonders(): array
    {
        /** @uses \App\Domain\Game\Wonder\Wonder::$id */
        $wonders = array_column($this->wonderRepository->data, 'id');
        shuffle($wonders);

        return $wonders;
    }

    /**
     * @return array<Cid>
     */
    private function getCards(Age $age): array
    {
        $cards = $this->cardRepository->getByAge($age);
        shuffle($cards);

        switch ($age) {
            case Age::III:
                $cards = array_slice($cards, 0, self::DECK_LIMIT - self::GUILDS_LIMIT);
                $guilds = $this->cardRepository->getGuilds();
                shuffle($guilds);
                array_push($cards, ...array_slice($guilds, 0, self::DECK_LIMIT));
                shuffle($cards);
                break;
            default:
                $cards = array_slice($cards, 0, self::DECK_LIMIT);
        }

        return $cards;
    }
}
