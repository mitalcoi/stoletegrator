<?php

namespace Product\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Product\Entity\Product;
use Product\Entity\User;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getById(int $id): Product
    {
        $user = $this->find($id);
        if(!$user){
            throw new EntityNotFoundException();
        }

        return $user;
    }

    /**
     * @param array<string, mixed> $filters
     * @return Product[]
     */
    public function findWithFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($filters['category'])) {
            $qb->andWhere('p.category = :category')
                ->setParameter('category', $filters['category']);
        }

        if (!empty($filters['sort'])) {
            $sortField = in_array($filters['sort'], ['name', 'category']) ? $filters['sort'] : 'p.name';
            $qb->orderBy('p.'.$sortField, 'ASC');
        }

        return $qb->getQuery()->getResult();
    }
}
