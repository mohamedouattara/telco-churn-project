<?php

        namespace App\Repository;
        
        use App\Entity\Conducteur;
        use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
        use Symfony\Bridge\Doctrine\RegistryInterface;
        
        /**
         * @method Conducteur|null find($id, $lockMode = null, $lockVersion = null)
         * @method Conducteur|null findOneBy(array $criteria, array $orderBy = null)
         * @method Conducteur[]    findAll()
         * @method Conducteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
         */
        class ConducteurRepository extends ServiceEntityRepository
        {
            public function __construct(RegistryInterface $registry)
            {
                parent::__construct($registry, Conducteur::class);
            }
            
          // /**
            //  * @return Conducteur[] Returns an array of Person objects
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
            public function findOneBySomeField($value): ?Conducteur
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
                
        