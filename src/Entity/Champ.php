<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChampRepository")
 */
class Champ
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelleChamp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeChamp;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Table", inversedBy="champs", cascade={"persist"})
     */
    private $table_;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleChamp(): ?string
    {
        return $this->libelleChamp;
    }

    public function setLibelleChamp(string $libelleChamp): self
    {
        $this->libelleChamp = $libelleChamp;

        return $this;
    }

    public function getTypeChamp(): ?string
    {
        return $this->typeChamp;
    }

    public function setTypeChamp(?string $typeChamp): self
    {
        $this->typeChamp = $typeChamp;

        return $this;
    }

    public function getTable(): ?Table
    {
        return $this->table_;
    }

    public function setTable(?Table $table_): self
    {
        $this->table_ = $table_;

        return $this;
    }
}
