<?php

        namespace App\Repository;
        
        use App\Entity\Tro;
        use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
        use Symfony\Bridge\Doctrine\RegistryInterface;
        
        /**
         * @method Tro|null find($id, $lockMode = null, $lockVersion = null)
         * @method Tro|null findOneBy(array $criteria, array $orderBy = null)
         * @method Tro[]    findAll()
         * @method Tro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
         */
        class TroRepository extends ServiceEntityRepository
        {
            public function __construct(RegistryInterface $registry)
            {
                parent::__construct($registry, Tro::class);
            }
            
          // /**
            //  * @return Tro[] Returns an array of Person objects
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
            public function findOneBySomeField($value): ?Tro
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
                
        