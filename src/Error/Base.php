<?php

namespace App\Error;

use Exception;

class Base extends Exception
{
    /**
     * Must be logged
     * @see ErrorsListener
     */
    private bool $loggable;

    /**
     * Can be show on client side
     *
     * @var bool
     */
    private bool $showable;

    public function __construct(
        string $message = '',
        bool $loggable = false,
        bool $showable = true,
    )
    {
        parent::__construct($message);

        $this->loggable = $loggable;
        $this->showable = $showable;
    }

    public function isLoggable(): bool
    {
        return $this->loggable;
    }

    public function isShowable(): bool
    {
        return $this->showable;
    }
}
