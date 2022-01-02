<?php

namespace App\Domain\Game\Token;

use App\Domain\Game\Discount\Context;
use App\Domain\Game\Discount\Discount;
use App\Domain\Game\Effect\Coins;
use App\Domain\Game\Effect\Discounter;
use App\Domain\Game\Effect\Mathematics;
use App\Domain\Game\Effect\Points;
use App\Domain\Game\Effect\Science;
use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\Symbol;

class Repository
{
    /**
     * @var array<int, Token>
     */
    private static ?array $data = null;

    public static function get(Id $token): Token
    {
        return self::getData()[$token->value];
    }

    /**
     * @return array<int, Token>
     */
    public static function getAll(): array
    {
        return self::getData();
    }

    /**
     * @return array<int, Token>
     */
    private static function getData(): array
    {
        if (!self::$data) {
            self::$data = [
                Id::Agriculture->value => new Token(
                    id: Id::Agriculture,
                    effects: [
                        new Coins(6),
                        new Points(4),
                    ],
                ),
                Id::Architecture->value => new Token(
                    id: Id::Architecture,
                    effects: [
                        new Discounter(new Discount(
                            Context::Wonder,
                            2,
                            Rid::Clay,
                            Rid::Wood,
                            Rid::Stone,
                            Rid::Glass,
                            Rid::Papyrus,
                        )),
                    ],
                ),
                Id::Economy->value => new Token(
                    id: Id::Economy,
                    effects: [
                        // uses only as HAS context
                    ],
                ),
                Id::Law->value => new Token(
                    id: Id::Law,
                    effects: [
                        new Science(Symbol::Law),
                    ],
                ),
                Id::Masonry->value => new Token(
                    id: Id::Masonry,
                    effects: [
                        new Discounter(new Discount(
                            Context::Civilian,
                            2,
                            Rid::Clay,
                            Rid::Wood,
                            Rid::Stone,
                            Rid::Glass,
                            Rid::Papyrus,
                        )),
                    ],
                ),
                Id::Mathematics->value => new Token(
                    id: Id::Mathematics,
                    effects: [
                        new Mathematics(),
                    ],
                ),
                Id::Philosophy->value => new Token(
                    id: Id::Philosophy,
                    effects: [
                        new Points(7),
                    ],
                ),
                Id::Strategy->value => new Token(
                    id: Id::Strategy,
                    effects: [
                        // uses only as HAS context
                    ],
                ),
                Id::Theology->value => new Token(
                    id: Id::Theology,
                    effects: [
                        // uses only as HAS context
                    ],
                ),
                Id::Urbanism->value => new Token(
                    id: Id::Urbanism,
                    effects: [
                        new Coins(6),
                        // + HAS usage
                    ],
                ),
            ];
        }

        return self::$data;
    }
}
