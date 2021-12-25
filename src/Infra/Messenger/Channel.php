<?php

namespace App\Infra\Messenger;

enum Channel: string
{
    case Online = 'stats:online';
    case NewRoom = 'new_room';
    case DelRoom = 'del_room';
    case UpdRoom = 'upd_room';
    case UpdGame = 'upd_game_%';
}
