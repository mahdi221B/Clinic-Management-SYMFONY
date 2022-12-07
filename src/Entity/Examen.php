<?php

namespace App\Entity;

use App\Repository\ExamenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExamenRepository::class)]
class Examen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\NotNull]
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: 'le nom de medecin ne peut pas etre inf à {{ limit }} ',
        maxMessage: 'le nom de medecin ne peut pas etre sup à {{ limit }} ',
    )]
    #[ORM\Column(length: 255)]
    private ?string $medecin = null;


    #[Assert\NotNull]
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: 'le nom de patient ne peut pas etre inf à {{ limit }} ',
        maxMessage: 'le nom de patient ne peut pas etre sup {{ limit }}',
    )]
    #[ORM\Column(length: 255)]
    private ?string $patient = null;

    #[Assert\NotNull]
    #[ORM\Column(length: 255)]
    private ?string $salle = null;

    #[Assert\NotNull]
    #[ORM\Column(length: 255)]
    private ?string $typeEx = null;

    #[Assert\NotNull]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEx = null;

    #[Assert\NotNull]
    #[ORM\Column(length: 255)]
    private ?string $resEx = null;

    #[ORM\ManyToOne(inversedBy: 'med')]
    private ?Medecin $med_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedecin(): ?string
    {
        return $this->medecin;
    }

    public function setMedecin(string $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getPatient(): ?string
    {
        return $this->patient;
    }

    public function setPatient(string $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(string $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getTypeEx(): ?string
    {
        return $this->typeEx;
    }

    public function setTypeEx(string $typeEx): self
    {
        $this->typeEx = $typeEx;

        return $this;
    }

    public function getDateEx(): ?\DateTimeInterface
    {
        return $this->dateEx;
    }

    public function setDateEx(\DateTimeInterface $dateEx): self
    {
        $this->dateEx = $dateEx;

        return $this;
    }

    public function getResEx(): ?string
    {
        return $this->resEx;
    }

    public function setResEx(string $resEx): self
    {
        $this->resEx = $resEx;

        return $this;
    }

    public function getMedId(): ?Medecin
    {
        return $this->med_id;
    }

    public function setMedId(?Medecin $med_id): self
    {
        $this->med_id = $med_id;

        return $this;
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
    }

}
