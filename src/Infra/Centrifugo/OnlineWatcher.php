<?php

namespace App\Infra\Centrifugo;

use phpcent\Client;

class OnlineWatcher
{
    public function __construct(
        private Client $client,
    )
    {
    }

    /**
     * @return string[]
     */
    public function watch(): array
    {
        return array_column(
            $this->client->presence(Channel::Online->value)['result']['presence'],
            'user',
        );
    }
}
