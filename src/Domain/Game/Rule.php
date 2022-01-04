<?php

namespace App\Domain\Game;

interface Rule
{
    public const BOARD_TOKENS_COUNT = 5;
    public const WONDERS_POOL_SIZE = 4;
    public const RANDOM_TOKENS_COUNT = 3;
    public const DECK_LIMIT = 20;
    public const GUILDS_LIMIT = 3;
    public const COINS_PER_POINT = 3;
    public const WONDERS_CONSTRUCT_LIMIT = 7;
    public const DEFAULT_RESOURCE_PRICE = 1;
    public const FIXED_RESOURCE_PRICE = 1;
    public const DEFAULT_DISCARD_REWARD = 2;
}
