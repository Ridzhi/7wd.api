<?php

namespace App\Handler;

use App\Contract\JwtEncoderInterface;
use App\Contract\UuidFactoryInterface;
use App\Domain\Player;
use App\Domain\Session;
use App\Domain\SessionRepository;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Throwable;

class CreateSessionHandler
{
    public function __construct(
        private SessionRepository    $sessionRepository,
        private UuidFactoryInterface $uuidFactory,
        private JwtEncoderInterface  $jwtEncoder,
        private CarbonInterval       $accessTokenTtl,
        private CarbonInterval       $refreshTokenTtl,
    )
    {
    }

    public function __invoke(Player $player, string $fingerprint): array
    {
        $session = (new Session())
            ->setPlayerId($player->getId())
            ->setRefreshToken($this->uuidFactory->v4())
            ->setFingerprint($fingerprint);

        try {
            $this->sessionRepository->persist($session, $this->refreshTokenTtl);
        } catch (Throwable) {
            throw new CustomUserMessageAuthenticationException('cant create session');
        }

        $accessToken = $this
            ->jwtEncoder
            ->encode([
                'id' => $player->getId(),
                'nickname' => $player->getNickname(),
                'exp' => Carbon::now()->getTimestamp() + (int)$this->accessTokenTtl->totalSeconds,
                //to support centrifugo
                'sub' => $player->getNickname(),
            ]);

        return [
            'accessToken' => $accessToken,
            'refreshToken' => $session->getRefreshToken(),
        ];
    }
}
