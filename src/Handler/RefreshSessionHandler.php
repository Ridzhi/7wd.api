<?php

namespace App\Handler;

use App\Domain\PlayerRepository;
use App\Domain\SessionRepository;
use App\Error\InvalidCredentialsError;
use App\Error\NotFoundError;
use App\Error\SecurityError;
use Psr\Cache\InvalidArgumentException;

class RefreshSessionHandler
{
    public function __construct(
        private SessionRepository    $sessionRepository,
        private PlayerRepository     $playerRepository,
        private CreateSessionHandler $createSessionHandler,
    )
    {
    }

    /**
     * @throws InvalidCredentialsError
     * @throws NotFoundError
     * @throws SecurityError
     * @throws InvalidArgumentException
     */
    public function __invoke(string $fingerprint, string $refreshToken): array
    {
        $session = $this->sessionRepository->find($fingerprint);

        if ($session === null) {
            throw new InvalidCredentialsError();
        }

        $this->sessionRepository->delete($fingerprint);

        if ($refreshToken !== $session->getRefreshToken()) {
            throw new SecurityError(
                sprintf(
                    'session compromised, player(%d), fingerprint(%s)',
                    $session->getPlayerId(),
                    $fingerprint,
                ),
            );
        }

        return ($this->createSessionHandler)(
            $this->playerRepository->get($session->getPlayerId()),
            $fingerprint,
        );
    }
}
