<?php

namespace App\Repository;

use App\Entity\Kitty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class KittyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kitty::class);
    }

    public function findRandomKitty(): Kitty {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT k FROM App:Kitty k ORDER BY RAND()'
            )
            ->setMaxResults(1)
            ->getSingleResult();
    }
}