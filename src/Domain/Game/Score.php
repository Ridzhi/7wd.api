<?php

namespace App\Domain\Game;

class Score
{
    public const COINS_PER_POINT = 3;

   public int $civilian;
   public int $science;
   public int $commercial;
   public int $guilds;
   public int $wonders;
   public int $tokens;
   public int $coins;
   public int $military;
   public int $total;
}
