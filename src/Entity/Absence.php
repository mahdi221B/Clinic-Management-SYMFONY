<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AbsenceRepository::class)]
class Absence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column]
    private ?string $Nom = null;
    #[ORM\Column]
    private ?string $Prenom = null;
    #[Assert\NotNull]
    #[Assert\Date]
    #[ORM\Column(length: 255)]
    private ?string $DateAbsence = null;



    #[Assert\NotNull]
    #[ORM\Column(length: 255)]
    private ?string $DureAbsence = null;

    #[Assert\NotNull]
    #[ORM\Column(length: 255)]
    private ?string $Justification = null;

    #[ORM\ManyToOne(inversedBy: 'absences')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getDateAbsence(): ?string
    {
        return $this->DateAbsence;
    }

    public function setDateAbsence(string $DateAbsence): self
    {
        $this->DateAbsence = $DateAbsence;

        return $this;
    }

    public function getDureAbsence(): ?string
    {
        return $this->DureAbsence;
    }

    public function setDureAbsence(string $DureAbsence): self
    {
        $this->DureAbsence = $DureAbsence;

        return $this;
    }

    public function getJustification(): ?string
    {
        return $this->Justification;
    }

    public function setJustification(string $Justification): self
    {
        $this->Justification = $Justification;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
