<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: SponsorRepository::class)]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Champ vide")]
    private ?string $nom_societe = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(message:"Ce E-mail '{{ value }}' est non valide ")]
    #[Assert\NotBlank(message:"Champ vide")]
    private ?string $email_societe = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Champ vide")]
    private ?int $phone_societe = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Champ vide")]
    private ?int $montant_donnee = null;

    #[ORM\Column(length: 255)]
    private ?string $type_sponsoring = null;

    #[ORM\ManyToMany(targetEntity: Evenement::class, mappedBy: 'sponsors')]
    private Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSociete(): ?string
    {
        return $this->nom_societe;
    }

    public function setNomSociete(string $nom_societe): self
    {
        $this->nom_societe = $nom_societe;

        return $this;
    }

    public function getEmailSociete(): ?string
    {
        return $this->email_societe;
    }

    public function setEmailSociete(string $email_societe): self
    {
        $this->email_societe = $email_societe;

        return $this;
    }

    public function getPhoneSociete(): ?int
    {
        return $this->phone_societe;
    }

    public function setPhoneSociete(int $phone_societe): self
    {
        $this->phone_societe = $phone_societe;

        return $this;
    }

    public function getMontantDonnee(): ?int
    {
        return $this->montant_donnee;
    }

    public function setMontantDonnee(int $montant_donnee): self
    {
        $this->montant_donnee = $montant_donnee;

        return $this;
    }

    public function getTypeSponsoring(): ?string
    {
        return $this->type_sponsoring;
    }

    public function setTypeSponsoring(string $type_sponsoring): self
    {
        $this->type_sponsoring = $type_sponsoring;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->addSponsor($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            $evenement->removeSponsor($this);
        }

        return $this;
    }
}
