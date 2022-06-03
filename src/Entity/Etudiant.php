<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant extends User
{
    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Inscription::class)]
    private $inscriptions;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $matricule;

    #[ORM\Column(type: 'boolean')]
    private $sexe;

    #[ORM\Column(type: 'text')]
    private $adresse;

    // #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Inscription::class)]
    // private $inscription;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setEtudiant($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getEtudiant() === $this) {
                $inscription->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function isSexe(): ?bool
    {
        return $this->sexe;
    }

    public function setSexe(bool $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    // /**
    //  * @return Collection<int, Inscription>
    //  */
    // public function getInscription(): Collection
    // {
    //     return $this->inscription;
    // }
}
