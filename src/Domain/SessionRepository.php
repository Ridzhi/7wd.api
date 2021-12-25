<?php

namespace App\Domain;

use Carbon\CarbonInterval;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use RuntimeException;

class SessionRepository
{
    private const TOKENS = ['session'];

    public function __construct(
        private CacheItemPoolInterface $cache,
    )
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function persist(Session $session, CarbonInterval $ttl)
    {
        $key = $this->key($session->getFingerprint());
        $item = $this->cache->getItem($key);

        $item->set($session);
        $item->expiresAfter($ttl->totalSeconds);

        if (!$this->cache->save($item)) {
            throw new RuntimeException('cant save session');
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function find(string $fingerprint): ?Session
    {
        return $this->cache->getItem($this->key($fingerprint))->get();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function delete(string $fingerprint): bool
    {
        return $this->cache->deleteItem($this->key($fingerprint));
    }

    private function key(string $fingerprint): string
    {
        return join('.', [
            ...self::TOKENS,
            ...[$fingerprint],
        ]);
    }
}
