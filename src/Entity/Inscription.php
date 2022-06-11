<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: AnneeScolaire::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $anneescolaire_id;

    #[ORM\ManyToOne(targetEntity: Ac::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $ac;

    #[ORM\ManyToOne(targetEntity: Etudiant::class, inversedBy: 'inscription')]
    #[ORM\JoinColumn(nullable: false)]
    private $etudiant;

    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $classes;



    public function __construct()
    {
        $this->acs = new ArrayCollection();
    }

    #[ORM\ManyToOne(targetEntity: Etudiant::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnneescolaireId(): ?AnneeScolaire
    {
        return $this->anneescolaire_id;
    }

    public function setAnneescolaireId(?AnneeScolaire $anneescolaire_id): self
    {
        $this->anneescolaire_id = $anneescolaire_id;

        return $this;
    }

    public function getAc(): ?Ac
    {
        return $this->ac;
    }

    public function setAc(?Ac $ac): self
    {
        $this->ac = $ac;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getClasses(): ?Classe
    {
        return $this->classes;
    }

    public function setClasses(?Classe $classes): self
    {
        $this->classes = $classes;

        return $this;
    }
}
