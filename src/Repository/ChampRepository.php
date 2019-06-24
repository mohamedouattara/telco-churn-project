<?php

namespace App\Repository;

use App\Entity\Champ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Champ|null find($id, $lockMode = null, $lockVersion = null)
 * @method Champ|null findOneBy(array $criteria, array $orderBy = null)
 * @method Champ[]    findAll()
 * @method Champ[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChampRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Champ::class);
    }

    // /**
    //  * @return Champ[] Returns an array of Champ objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Champ
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
