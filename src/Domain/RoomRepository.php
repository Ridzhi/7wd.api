<?php

namespace App\Domain;

use App\Error\NotFoundError;
use App\Error\RoomError;
use Redis;
use RuntimeException;
use Symfony\Component\Serializer\SerializerInterface;

class RoomRepository
{
    private const KEY_LIST = 'rooms';

    public function __construct(
        private Redis               $redis,
        private SerializerInterface $serializer,
    )
    {
    }

    /**
     * @throws RoomError
     */
    public function persist(Room $room): void
    {
        $this->redis->multi();

        $this->redis->sAdd(self::KEY_LIST, $room->getHost());

        $this->redis->set(
            $this->kItem($room->getHost()),
            $this->serializer->serialize($room, 'json'),
        );

        [$sAdd, $set] = $this->redis->exec();

        // @see https://github.com/phpredis/phpredis/issues/2002
        if ($sAdd === false || $sAdd === 0) {
            $this->redis->discard();

            throw new RoomError('one room per player');
        }

        if ($set !== true) {
            $this->redis->discard();

            throw new RuntimeException();
        }
    }

    /**
     * @throws NotFoundError
     */
    public function update(Room $room): void
    {
        $this->redis->set(
            $this->kItem($room->getHost()),
            $this->serializer->serialize($room, 'json'),
            ['xx'],
        )
            ?: throw new NotFoundError($room->getHost(), 'room');
    }

    /**
     * @throws NotFoundError
     */
    public function remove(string $host): void
    {
        $ok1 = $this->redis->sRem(self::KEY_LIST, $host) > 0;

        $ok2 = $this->redis->del($this->kItem($host)) > 0;

        $ok1 && $ok2
            ?: throw new NotFoundError($host, 'room');
    }

    /**
     * @throws NotFoundError
     */
    public function get(string $host): Room
    {
        return $this->find($host) ?? throw new NotFoundError($host, 'room');
    }

    public function find(string $host): ?Room
    {
        $room = $this->redis->get($this->kItem($host));

        if ($room === false) {
            return null;
        }

        return $this->serializer->deserialize($room, Room::class, 'json');
    }

    /**
     * @return array<Room>
     */
    public function findAll(): array
    {
        $rooms = [];

        foreach ($this->findHosts() as $host) {
            $room = $this->find($host);

            // unrealistic case
            if ($room === null) {
                throw new RuntimeException('rooms are out of sync');
            }

            $rooms[] = $room;
        }

        return $rooms;
    }

    public function findHosts(): array
    {
        return $this->redis->sMembers(self::KEY_LIST);
    }

    private function kItem(string $host): string
    {
        return sprintf('room:%s', $host);
    }
}
