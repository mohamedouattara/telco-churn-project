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
             * @ORM\Column(type="string", length=255, nullable=true)
             */
            private $prenom;
             /**
             * @ORM\Column(type="datetime", nullable=true)
             */
              private $date;
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
                    
                    
                         public function getDate(): ?\DateTimeInterface
                        {
                            return $this->date;
                        }
                    
                        public function setDate(?\DateTimeInterface $date): self
                        {
                            $this->date = $date;
                    
                            return $this;
                        }
                    }