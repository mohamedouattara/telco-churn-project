<?php

        namespace App\Repository;
        
        use App\Entity\Uubhj;
        use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
        use Symfony\Bridge\Doctrine\RegistryInterface;
        
        /**
         * @method Uubhj|null find($id, $lockMode = null, $lockVersion = null)
         * @method Uubhj|null findOneBy(array $criteria, array $orderBy = null)
         * @method Uubhj[]    findAll()
         * @method Uubhj[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
         */
        class UubhjRepository extends ServiceEntityRepository
        {
            public function __construct(RegistryInterface $registry)
            {
                parent::__construct($registry, Uubhj::class);
            }
            
          // /**
            //  * @return Uubhj[] Returns an array of Person objects
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
            public function findOneBySomeField($value): ?Uubhj
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
                
        