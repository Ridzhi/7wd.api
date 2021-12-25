<?php

namespace App\Infra\Command\Daemon;

use App\Infra\Centrifugo\Channel;
use App\Infra\Centrifugo\OnlineWatcher;
use phpcent\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Online extends Command
{
    private const DELAY_SECONDS = 3;

    protected static $defaultName = 'daemon:online';

    public function __construct(
        private Client        $client,
        private OnlineWatcher $watcher,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        while (true) {
            $players = $this->watcher->watch();
            $this->client->publish(Channel::Online->value, $players);

            sleep(self::DELAY_SECONDS);
        }

        /** @noinspection PhpUnreachableStatementInspection */
        return 0;
    }
}
