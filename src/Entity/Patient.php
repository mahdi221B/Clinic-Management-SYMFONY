<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomprenomp = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dnp = null;

    #[ORM\Column(length: 255)]
    private ?string $sexep = null;

    #[Assert\NotNull]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[ORM\Column(length: 255)]
    private ?string $adrp = null;

    #[ORM\Column]
    private ?int $age = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomprenomp(): ?string
    {
        return $this->nomprenomp;
    }

    public function setNomprenomp(string $nomprenomp): self
    {
        $this->nomprenomp = $nomprenomp;

        return $this;
    }

    public function getDnp(): ?\DateTimeInterface
    {
        return $this->dnp;
    }

    public function setDnp(\DateTimeInterface $dnp): self
    {
        $this->dnp = $dnp;

        return $this;
    }

    public function getSexep(): ?string
    {
        return $this->sexep;
    }

    public function setSexep(string $sexep): self
    {
        $this->sexep = $sexep;

        return $this;
    }

    public function getAdrp(): ?string
    {
        return $this->adrp;
    }

    public function setAdrp(string $adrp): self
    {
        $this->adrp = $adrp;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }
}
