<?php

namespace App\Domain;

use App\Error\NotFoundError;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

//    /**
//     * Used to upgrade (rehash) the user's password automatically over time.
//     */
//    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
//    {
//        if (!$user instanceof Player) {
//            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
//        }
//
//        $user->setPassword($newHashedPassword);
//        $this->_em->persist($user);
//        $this->_em->flush();
//    }

    /**
     * @throws NotFoundError
     */
    public function get(int $id): Player
    {
        return $this->find($id) ?? throw new NotFoundError($id, 'player');
    }

    public function findByEmail(string $email): ?Player
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findByNickname(string $nickname): ?Player
    {
        return $this->findOneBy(['nickname' => $nickname]);
    }
}
