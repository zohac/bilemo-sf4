<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Return the list of product with all associated entities.
     *
     * @return array|null
     */
    public function findAllWhithAllEntities(): ?array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.pictures', 'pic')
            ->addSelect('pic')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return a product with all associated entities.
     *
     * @param int $value
     *
     * @return Product|null
     */
    public function findOneWhithAllEntities(int $value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.pictures', 'pic')
            ->addSelect('pic')
            ->andWhere('p.id = :id')
            ->setParameter('id', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
