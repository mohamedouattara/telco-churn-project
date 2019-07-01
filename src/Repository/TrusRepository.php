<?php

        namespace App\Repository;
        
        use App\Entity\Trus;
        use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
        use Symfony\Bridge\Doctrine\RegistryInterface;
        
        /**
         * @method Trus|null find($id, $lockMode = null, $lockVersion = null)
         * @method Trus|null findOneBy(array $criteria, array $orderBy = null)
         * @method Trus[]    findAll()
         * @method Trus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
         */
        class TrusRepository extends ServiceEntityRepository
        {
            public function __construct(RegistryInterface $registry)
            {
                parent::__construct($registry, Trus::class);
            }
            
          // /**
            //  * @return Trus[] Returns an array of Person objects
            //  */
            /*
            public function findByExampleField($value)
            {
                return $this->createQueryBuilder("p")
                    ->andWhere("p.exampleField = :val")
                    ->setParameter("val", $value)
                    ->orderBy("p.id", "ASC")
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                ;
            }
            */
        
            /*
            public function findOneBySomeField($value): ?Trus
            {
                return $this->createQueryBuilder("p")
                    ->andWhere("p.exampleField = :val")
                    ->setParameter("val", $value)
                    ->getQuery()
                    ->getOneOrNullResult()
                ;
            }
            */
         
         }
                
        