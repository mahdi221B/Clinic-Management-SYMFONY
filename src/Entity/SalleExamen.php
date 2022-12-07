<?php

namespace App\Entity;

use App\Repository\SalleExamenRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SalleExamenRepository::class)]
class SalleExamen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idSalle = null;

    #[ORM\Column]
    private ?int $idEx = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSalle(): ?int
    {
        return $this->idSalle;
    }

    public function setIdSalle(int $idSalle): self
    {
        $this->idSalle = $idSalle;

        return $this;
    }

    public function getIdEx(): ?int
    {
        return $this->idEx;
    }

    public function setIdEx(int $idEx): self
    {
        $this->idEx = $idEx;

        return $this;
    }
}
