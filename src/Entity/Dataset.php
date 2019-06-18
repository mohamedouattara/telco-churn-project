<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DatasetRepository")
 */
class Dataset
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
    private $gender;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $seniorcitizen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $partner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dependents;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneservice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $multiplelines;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $internetservice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $onlinesecurity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $onlinebackup;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deviceprotection;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $techsupport;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $streamingtv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $streamingmovies;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contract;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paperlessbilling;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paymentmethod;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tenure;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $monthlycharges;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalcharges;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $churn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getSeniorcitizen(): ?bool
    {
        return $this->seniorcitizen;
    }

    public function setSeniorcitizen(?bool $seniorcitizen): self
    {
        $this->seniorcitizen = $seniorcitizen;

        return $this;
    }

    public function getPartner(): ?string
    {
        return $this->partner;
    }

    public function setPartner(?string $partner): self
    {
        $this->partner = $partner;

        return $this;
    }

    public function getDependents(): ?string
    {
        return $this->dependents;
    }

    public function setDependents(?string $dependents): self
    {
        $this->dependents = $dependents;

        return $this;
    }

    public function getPhoneservice(): ?string
    {
        return $this->phoneservice;
    }

    public function setPhoneservice(?string $phoneservice): self
    {
        $this->phoneservice = $phoneservice;

        return $this;
    }

    public function getMultiplelines(): ?string
    {
        return $this->multiplelines;
    }

    public function setMultiplelines(?string $multiplelines): self
    {
        $this->multiplelines = $multiplelines;

        return $this;
    }

    public function getInternetservice(): ?string
    {
        return $this->internetservice;
    }

    public function setInternetservice(?string $internetservice): self
    {
        $this->internetservice = $internetservice;

        return $this;
    }

    public function getOnlinesecurity(): ?string
    {
        return $this->onlinesecurity;
    }

    public function setOnlinesecurity(?string $onlinesecurity): self
    {
        $this->onlinesecurity = $onlinesecurity;

        return $this;
    }

    public function getOnlinebackup(): ?string
    {
        return $this->onlinebackup;
    }

    public function setOnlinebackup(?string $onlinebackup): self
    {
        $this->onlinebackup = $onlinebackup;

        return $this;
    }

    public function getDeviceprotection(): ?string
    {
        return $this->deviceprotection;
    }

    public function setDeviceprotection(?string $deviceprotection): self
    {
        $this->deviceprotection = $deviceprotection;

        return $this;
    }

    public function getTechsupport(): ?string
    {
        return $this->techsupport;
    }

    public function setTechsupport(?string $techsupport): self
    {
        $this->techsupport = $techsupport;

        return $this;
    }

    public function getStreamingtv(): ?string
    {
        return $this->streamingtv;
    }

    public function setStreamingtv(?string $streamingtv): self
    {
        $this->streamingtv = $streamingtv;

        return $this;
    }

    public function getStreamingmovies(): ?string
    {
        return $this->streamingmovies;
    }

    public function setStreamingmovies(?string $streamingmovies): self
    {
        $this->streamingmovies = $streamingmovies;

        return $this;
    }

    public function getContract(): ?string
    {
        return $this->contract;
    }

    public function setContract(?string $contract): self
    {
        $this->contract = $contract;

        return $this;
    }

    public function getPaperlessbilling(): ?string
    {
        return $this->paperlessbilling;
    }

    public function setPaperlessbilling(?string $paperlessbilling): self
    {
        $this->paperlessbilling = $paperlessbilling;

        return $this;
    }

    public function getPaymentmethod(): ?string
    {
        return $this->paymentmethod;
    }

    public function setPaymentmethod(?string $paymentmethod): self
    {
        $this->paymentmethod = $paymentmethod;

        return $this;
    }

    public function getTenure(): ?int
    {
        return $this->tenure;
    }

    public function setTenure(?int $tenure): self
    {
        $this->tenure = $tenure;

        return $this;
    }

    public function getMonthlycharges(): ?float
    {
        return $this->monthlycharges;
    }

    public function setMonthlycharges(?float $monthlycharges): self
    {
        $this->monthlycharges = $monthlycharges;

        return $this;
    }

    public function getTotalcharges(): ?float
    {
        return $this->totalcharges;
    }

    public function setTotalcharges(?float $totalcharges): self
    {
        $this->totalcharges = $totalcharges;

        return $this;
    }

    public function getChurn(): ?string
    {
        return $this->churn;
    }

    public function setChurn(?string $churn): self
    {
        $this->churn = $churn;

        return $this;
    }
}
