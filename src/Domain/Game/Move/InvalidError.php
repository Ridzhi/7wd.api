<?php

namespace App\Domain\Game\Move;

class InvalidError extends \App\Error\Error
{
    public function __construct()
    {
        parent::__construct(
            'invalid move',
            loggable: true,
            showable: false,
        );
    }
}
