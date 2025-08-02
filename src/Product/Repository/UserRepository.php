<?php

namespace Product\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Product\Entity\Product;
use Product\Entity\User;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getByIdentifier(string $identifier): User
    {
        $user = $this->findOneBy(['username'=>$identifier]);
        if(!$user){
            throw new EntityNotFoundException();
        }

        return $user;
    }
}
