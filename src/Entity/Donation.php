<?php

namespace App\Entity;

use App\Repository\DonationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonationRepository::class)]
class Donation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'donations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenement $listeevents = null;

    #[ORM\ManyToOne(inversedBy: 'donations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sponsor $listesponsors = null;

    #[ORM\Column]
    private ?float $montants = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListeevents(): ?Evenement
    {
        return $this->listeevents;
    }

    public function setListeevents(?Evenement $listeevents): self
    {
        $this->listeevents = $listeevents;

        return $this;
    }

    public function getListesponsors(): ?Sponsor
    {
        return $this->listesponsors;
    }

    public function setListesponsors(?Sponsor $listesponsors): self
    {
        $this->listesponsors = $listesponsors;

        return $this;
    }

    public function getMontants(): ?float
    {
        return $this->montants;
    }

    public function setMontants(float $montants): self
    {
        $this->montants = $montants;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
