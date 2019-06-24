<?php

            namespace App\Entity;
            
            use Doctrine\ORM\Mapping as ORM;
            
            /**
             * @ORM\Entity(repositoryClass="App\Repository\ConducteurRepository")
             */
             class Conducteur{
             
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
             * @ORM\Column(type="string", length=255, nullable=true)
             */
            private $prenom;
            /**
             * @ORM\Column(type="string", length=255, nullable=true)
             */
            private $numeropermis;
             /**
             * @ORM\Column(type="integer", nullable=true)
             */
              private $age;
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
                    
                        public function getPrenom(): ?string
                        {
                            return $this->prenom;
                        }
                    
                        public function setPrenom(?string $prenom): self
                        {
                            $this->prenom = $prenom;
                    
                            return $this;
                        }
                    
                        public function getNumeropermis(): ?string
                        {
                            return $this->numeropermis;
                        }
                    
                        public function setNumeropermis(?string $numeropermis): self
                        {
                            $this->numeropermis = $numeropermis;
                    
                            return $this;
                        }
                    
                    
                         public function getAge(): ?int
                        {
                            return $this->age;
                        }
                    
                        public function setAge(?int $age): self
                        {
                            $this->age = $age;
                    
                            return $this;
                        }
                    }