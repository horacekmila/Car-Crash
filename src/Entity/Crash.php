<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CrashRepository")
 */
class Crash
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $accidentAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fine;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car", inversedBy="crashes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $car;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccidentAt(): ?\DateTimeInterface
    {
        return $this->accidentAt;
    }

    public function setAccidentAt(\DateTimeInterface $accidentAt): self
    {
        $this->accidentAt = $accidentAt;

        return $this;
    }

    public function getFine(): ?int
    {
        return $this->fine;
    }

    public function setFine(?int $fine): self
    {
        $this->fine = $fine;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }
}
