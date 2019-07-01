<?php

        namespace App\Repository;
        
        use App\Entity\Vehicule;
        use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
        use Symfony\Bridge\Doctrine\RegistryInterface;
        
        /**
         * @method Vehicule|null find($id, $lockMode = null, $lockVersion = null)
         * @method Vehicule|null findOneBy(array $criteria, array $orderBy = null)
         * @method Vehicule[]    findAll()
         * @method Vehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
         */
        class VehiculeRepository extends ServiceEntityRepository
        {
            public function __construct(RegistryInterface $registry)
            {
                parent::__construct($registry, Vehicule::class);
            }
            
          // /**
            //  * @return Vehicule[] Returns an array of Person objects
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
            public function findOneBySomeField($value): ?Vehicule
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
                
        