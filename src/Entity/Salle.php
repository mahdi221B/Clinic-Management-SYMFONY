<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SalleRepository::class)]
class Salle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idEtageSalle = null;

    #[ORM\Column(length: 255)]
    private ?string $blocS = null;

    #[ORM\Column(length: 255)]
    private ?string $appareilUtlise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEtageSalle(): ?int
    {
        return $this->idEtageSalle;
    }

    public function setIdEtageSalle(int $idEtageSalle): self
    {
        $this->idEtageSalle = $idEtageSalle;

        return $this;
    }

    public function getBlocS(): ?string
    {
        return $this->blocS;
    }

    public function setBlocS(string $blocS): self
    {
        $this->blocS = $blocS;

        return $this;
    }

    public function getAppareilUtlise(): ?string
    {
        return $this->appareilUtlise;
    }

    public function setAppareilUtlise(string $appareilUtlise): self
    {
        $this->appareilUtlise = $appareilUtlise;

        return $this;
    }
}
