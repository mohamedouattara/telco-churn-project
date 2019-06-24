<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TableRepository")
 */
class Table
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
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Champ", mappedBy="table_")
     */
    private $champs;

    public function __construct()
    {
        $this->champs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Champ[]
     */
    public function getChamps(): Collection
    {
        return $this->champs;
    }

    public function addChamp(Champ $field): self
    {
        if (!$this->champs->contains($field)) {
            $this->champs[] = $field;
            $field->setTable($this);
        }

        return $this;
    }

    public function removeChamps(Champ $field): self
    {
        if ($this->champs->contains($field)) {
            $this->champs->removeElement($field);
            // set the owning side to null (unless already changed)
            if ($field->getTable() === $this) {
                $field->setTable(null);
            }
        }

        return $this;
    }
}
