<?php

namespace App\Entity;

use App\Repository\RendezvousRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RendezvousRepository::class)]
class Rendezvous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\NotBlank(message:"champ vide")]
    #[ORM\Column(length: 255)]
    private ?string $dateRDV = null;
    #[Assert\NotBlank(message:"champ vide")]
    #[ORM\Column(length: 255)]
    private ?string $heureRDv = null;
    #[Assert\NotBlank(message:"champ vide")]
    #[ORM\Column(length: 255)]
    private ?string $nomPatinet = null;
    #[Assert\NotBlank(message:"champ vide")]
    #[ORM\Column(length: 255)]
    private ?string $cause = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRDV(): ?string
    {
        return $this->dateRDV;
    }

    public function setDateRDV(string $dateRDV): self
    {
        $this->dateRDV = $dateRDV;

        return $this;
    }

    public function getHeureRDv(): ?string
    {
        return $this->heureRDv;
    }

    public function setHeureRDv(string $heureRDv): self
    {
        $this->heureRDv = $heureRDv;

        return $this;
    }

    public function getNomPatinet(): ?string
    {
        return $this->nomPatinet;
    }

    public function setNomPatinet(string $nomPatinet): self
    {
        $this->nomPatinet = $nomPatinet;

        return $this;
    }

    public function getCause(): ?string
    {
        return $this->cause;
    }

    public function setCause(string $cause): self
    {
        $this->cause = $cause;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
