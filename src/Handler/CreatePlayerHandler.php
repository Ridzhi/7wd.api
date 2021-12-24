<?php

namespace App\Handler;

use App\Domain\Player;
use App\Error\Error;
use App\Error\NotVerifiedEmailError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreatePlayerHandler
{
    public function __construct(
        private EntityManagerInterface        $em,
        private UserPasswordHasherInterface   $hasher,
        private CheckEmailVerificationHandler $checkEmailVerificationHandler,
    )
    {
    }

    /**
     * @throws NotVerifiedEmailError
     */
    public function __invoke(
        string $email,
        string $password,
        string $confirmationCode,
        string $nickname,
    ): Player
    {
        try {
            ($this->checkEmailVerificationHandler)($email, $confirmationCode);
        } catch (Error) {
            throw new NotVerifiedEmailError($email);
        }

        $player = (new Player())
            ->setEmail($email)
            ->setNickname($nickname)
            ->setRating(1500);

        $player->setPassword($this->hasher->hashPassword($player, $password));

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }
}
