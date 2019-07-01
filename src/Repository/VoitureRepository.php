<?php

        namespace App\Repository;
        
        use App\Entity\Voiture;
        use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
        use Symfony\Bridge\Doctrine\RegistryInterface;
        
        /**
         * @method Voiture|null find($id, $lockMode = null, $lockVersion = null)
         * @method Voiture|null findOneBy(array $criteria, array $orderBy = null)
         * @method Voiture[]    findAll()
         * @method Voiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
         */
        class VoitureRepository extends ServiceEntityRepository
        {
            public function __construct(RegistryInterface $registry)
            {
                parent::__construct($registry, Voiture::class);
            }
            
          // /**
            //  * @return Voiture[] Returns an array of Person objects
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
            public function findOneBySomeField($value): ?Voiture
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
                
        