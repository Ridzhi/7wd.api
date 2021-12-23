<?php

namespace App\Infra\Security;

use App\Contract\JwtDecoderInterface;
use App\Error\InvalidCredentialsError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class JwtAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private JwtDecoderInterface $jwtDecoder,
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request): ?bool
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws InvalidCredentialsError
     */
    public function authenticate(Request $request): Passport
    {
        $authHeader = $request->headers->get("Authorization");

        if (null === $authHeader) {
            throw new InvalidCredentialsError();
        }

        $token = substr($authHeader, 7);
        $payload = $this->jwtDecoder->decode($token);

        $userBadge = new UserBadge(
            '',
            fn() => new \App\Domain\Passport($payload['id'], $payload['nickname'])
        );

        return new SelfValidatingPassport($userBadge);
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    /**
     * @inheritDoc
     * @throws InvalidCredentialsError
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        throw new InvalidCredentialsError();
    }
}
