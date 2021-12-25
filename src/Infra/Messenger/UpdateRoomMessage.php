<?php

namespace App\Infra\Messenger;

use App\Domain\Room;

class UpdateRoomMessage
{
    public function __construct(
        private Room $room,
    )
    {
    }

    public function getRoom(): Room
    {
        return $this->room;
    }
}
