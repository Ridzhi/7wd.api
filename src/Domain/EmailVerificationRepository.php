<?php

namespace App\Domain;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmailVerification|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailVerification|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailVerification[]    findAll()
 * @method EmailVerification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailVerificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailVerification::class);
    }

    public function findByEmail(string $email): ?EmailVerification
    {
        return $this->findOneBy(['email' => $email]);
    }
}
