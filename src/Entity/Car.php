<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
{
    const PERSONAL = "personal";
    const PROFESIONAL = "profesional";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $licencePlate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Crash", mappedBy="car", orphanRemoval=true)
     */
    private $crashes;

    public function __construct()
    {
        $this->crashes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicencePlate(): ?string
    {
        return $this->licencePlate;
    }

    public function setLicencePlate(string $licencePlate): self
    {
        $this->licencePlate = $licencePlate;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Crash[]
     */
    public function getCrashes(): Collection
    {
        return $this->crashes;
    }

    public function addCrash(Crash $crash): self
    {
        if (!$this->crashes->contains($crash)) {
            $this->crashes[] = $crash;
            $crash->setCar($this);
        }

        return $this;
    }

    public function removeCrash(Crash $crash): self
    {
        if ($this->crashes->contains($crash)) {
            $this->crashes->removeElement($crash);
            // set the owning side to null (unless already changed)
            if ($crash->getCar() === $this) {
                $crash->setCar(null);
            }
        }

        return $this;
    }
}
