<?php

        namespace App\Repository;
        
        use App\Entity\Troy;
        use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
        use Symfony\Bridge\Doctrine\RegistryInterface;
        
        /**
         * @method Troy|null find($id, $lockMode = null, $lockVersion = null)
         * @method Troy|null findOneBy(array $criteria, array $orderBy = null)
         * @method Troy[]    findAll()
         * @method Troy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
         */
        class TroyRepository extends ServiceEntityRepository
        {
            public function __construct(RegistryInterface $registry)
            {
                parent::__construct($registry, Troy::class);
            }
            
          // /**
            //  * @return Troy[] Returns an array of Person objects
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
            public function findOneBySomeField($value): ?Troy
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
                
        