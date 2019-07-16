<?php

            namespace App\Entity;
            
            use Doctrine\ORM\Mapping as ORM;
            use App\Form\Enums\ClasseTypeEnum;
            
            /**
             * @ORM\Entity(repositoryClass="App\Repository\ClasseRepository")
             */
             class Classe{
             
                /**
                 * @ORM\Id()
                 * @ORM\GeneratedValue()
                 * @ORM\Column(type="integer")
                 */
                private $id;
          
             /**
             * @ORM\Column(type="datetime", nullable=true)
             */
              private $annee;
             /**
             * @ORM\Column(type="float", nullable=true)
             */
              private $effectif;
                    /**
                     * @ORM\Column(type="string", length=255, nullable=true)
                     */
                    private $professeurprincipal;
                public function getId(): ?int
                {
                    return $this->id;
                }
            
                    
                         public function getAnnee(): ?\DateTimeInterface
                        {
                            return $this->annee;
                        }
                    
                        public function setAnnee(?\DateTimeInterface $annee): self
                        {
                            $this->annee = $annee;
                    
                            return $this;
                        }
                    
                    
                         public function getEffectif(): ?float
                        {
                            return $this->effectif;
                        }
                    
                        public function setEffectif(?float $effectif): self
                        {
                            $this->effectif = $effectif;
                    
                            return $this;
                        }
                    
                        public function getProfesseurprincipal(): ?string
                        {
                            return $this->professeurprincipal;
                        }
                    
                        public function setProfesseurprincipal(?string $professeurprincipal): self
                        {
                            $this->professeurprincipal = $professeurprincipal;
                    
                            return $this;
                        }
                    }