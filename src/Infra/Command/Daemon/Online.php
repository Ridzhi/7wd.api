<?php

namespace App\Infra\Command\Daemon;

use App\Domain\RoomRepository;
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
        private Client         $client,
        private OnlineWatcher  $watcher,
        private RoomRepository $roomRepository,
    )
    {
        parent::__construct();
    }

    /**
     * Expected online is 0-50 people, just send full list
     * Otherwise TODO cache last result and send diff{added: int, leaved: int}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        while (true) {
            $players = $this->watcher->watch();
            $playersSearch = array_flip($players);

            // remove offline player rooms
            foreach ($this->roomRepository->findAll() as $room) {
                if (
                    !isset($playersSearch[$room->getHost()])
                    && $room->getGameId() === null
                ) {
                    $this->roomRepository->remove($room->getHost());
                    $this->client->publish(
                        Channel::DelRoom->value,
                        ['host' => $room->getHost()],
                    );
                }
            }

            $this->client->publish(Channel::Online->value, $players);

            sleep(self::DELAY_SECONDS);
        }

        /** @noinspection PhpUnreachableStatementInspection */
        return 0;
    }
}
