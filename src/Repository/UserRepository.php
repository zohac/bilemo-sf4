<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Return the list of product with all associated entities.
     *
     * @return array|null
     */
    public function findAllWhithAllEntities(User $user): ?array
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.customer', 'c')
            ->addSelect('c')
            ->andWhere('c.name = :customer')
            ->setParameter('customer', $user->getCustomer()->getName())
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return a user with all associated entities.
     *
     * @param int $value
     *
     * @return User|null
     */
    public function findOneWhithAllEntities(int $value): ?User
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.customer', 'c')
            ->addSelect('c')
            ->andWhere('u.id = :id')
            ->setParameter('id', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
