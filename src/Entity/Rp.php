<?php

namespace App\Entity;

use App\Repository\RpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RpRepository::class)]
class Rp extends User
{

    #[ORM\OneToMany(mappedBy: 'rp', targetEntity: Classe::class)]
    private $classe;

    #[ORM\OneToMany(mappedBy: 'rp', targetEntity: Professeur::class)]
    private $professeur;

    // #[ORM\ManyToOne(targetEntity: Ac::class, inversedBy: 'rp')]
    // #[ORM\JoinColumn(nullable: false)]
    // private $ac;

    public function __construct()
    {
        $this->classe = new ArrayCollection();
        $this->professeur = new ArrayCollection();
    }



    /**
     * @return Collection<int, Classe>
     */
    public function getClasse(): Collection
    {
        return $this->classe;
    }

    public function addClasse(Classe $classe): self
    {
        if (!$this->classe->contains($classe)) {
            $this->classe[] = $classe;
            $classe->setRp($this);
        }

        return $this;
    }

    public function removeClasse(Classe $classe): self
    {
        if ($this->classe->removeElement($classe)) {
            // set the owning side to null (unless already changed)
            if ($classe->getRp() === $this) {
                $classe->setRp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Professeur>
     */
    public function getProfesseur(): Collection
    {
        return $this->professeur;
    }

    public function addProfesseur(Professeur $professeur): self
    {
        if (!$this->professeur->contains($professeur)) {
            $this->professeur[] = $professeur;
            $professeur->setRp($this);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): self
    {
        if ($this->professeur->removeElement($professeur)) {
            // set the owning side to null (unless already changed)
            if ($professeur->getRp() === $this) {
                $professeur->setRp(null);
            }
        }

        return $this;
    }
}
