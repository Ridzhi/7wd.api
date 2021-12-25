<?php

namespace App\Adapter;

use phpcent\Client;

class CentrifugoClientFactory
{
    public function factory(string $url, string $apikey): Client
    {
        return (new Client($url, $apikey))
            ->setUseAssoc(true);
    }
}
