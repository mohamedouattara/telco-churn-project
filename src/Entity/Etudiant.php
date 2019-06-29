<?php

            namespace App\Entity;
            
            use Doctrine\ORM\Mapping as ORM;
            
            /**
             * @ORM\Entity(repositoryClass="App\Repository\EtudiantRepository")
             */
             class Etudiant{
             
                /**
                 * @ORM\Id()
                 * @ORM\GeneratedValue()
                 * @ORM\Column(type="integer")
                 */
                private $id;
          
            /**
             * @ORM\Column(type="string", length=255, nullable=true)
             */
            private $nom;
             /**
             * @ORM\Column(type="float", nullable=true)
             */
              private $age;
             /**
             * @ORM\Column(type="datetime", nullable=true)
             */
              private $datedenaissance;
                public function getId(): ?int
                {
                    return $this->id;
                }
            
                        public function getNom(): ?string
                        {
                            return $this->nom;
                        }
                    
                        public function setNom(?string $nom): self
                        {
                            $this->nom = $nom;
                    
                            return $this;
                        }
                    
                    
                         public function getAge(): ?float
                        {
                            return $this->age;
                        }
                    
                        public function setAge(?float $age): self
                        {
                            $this->age = $age;
                    
                            return $this;
                        }
                    
                    
                         public function getDatedenaissance(): ?\DateTimeInterface
                        {
                            return $this->datedenaissance;
                        }
                    
                        public function setDatedenaissance(?\DateTimeInterface $datedenaissance): self
                        {
                            $this->datedenaissance = $datedenaissance;
                    
                            return $this;
                        }
                    }