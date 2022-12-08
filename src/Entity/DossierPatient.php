<?php

namespace App\Entity;

use App\Repository\DossierPatientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DossierPatientRepository::class)]
class DossierPatient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message:"champ vide")]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;
    #[Assert\NotBlank(message:"champ vide")]
    #[ORM\Column(length: 255)]
    private ?string $allergieMedic = null;
    #[Assert\NotBlank(message:"champ vide")]
    #[ORM\Column(length: 255)]
    private ?string $medicaments = null;
    #[Assert\NotBlank(message:"champ vide")]
    #[ORM\Column(length: 255)]
    private ?string $maladies = null;
    #[Assert\NotBlank(message:"champ vide")]
    #[ORM\Column(length: 255)]
    private ?string $detailsOperations = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAllergieMedic(): ?string
    {
        return $this->allergieMedic;
    }

    public function setAllergieMedic(string $allergieMedic): self
    {
        $this->allergieMedic = $allergieMedic;

        return $this;
    }

    public function getMedicaments(): ?string
    {
        return $this->medicaments;
    }

    public function setMedicaments(string $medicaments): self
    {
        $this->medicaments = $medicaments;

        return $this;
    }

    public function getMaladies(): ?string
    {
        return $this->maladies;
    }

    public function setMaladies(string $maladies): self
    {
        $this->maladies = $maladies;

        return $this;
    }

    public function getDetailsOperations(): ?string
    {
        return $this->detailsOperations;
    }

    public function setDetailsOperations(string $detailsOperations): self
    {
        $this->detailsOperations = $detailsOperations;

        return $this;
    }
}
