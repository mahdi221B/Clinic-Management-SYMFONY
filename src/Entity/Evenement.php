<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3)]
    #[Assert\NotBlank(message:"Champ vide")]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 10)]
    #[Assert\NotBlank(message:"Champ vide")]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Champ vide")]
    private ?string $lieu = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Champ vide")]
    private ?string $nom_organisateur = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Champ vide")]
    #[Assert\Email(message:"Ce E-mail '{{ value }}' est non valide ")]
    private ?string $email_organisateur = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Champ vide")]
    private ?int $phone_organisateur = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Champ vide")]
    #[Assert\Date]
    private ?string $date_debut = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Champ vide")]
    #[Assert\Date]
    private ?string $date_fin = null;

    #[ORM\Column]
    private ?int $montant_recole = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"You have to add a picture")]
    private ?string $picture = null;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?TypeEvenement $typeEvenement = null;

    #[ORM\OneToMany(mappedBy: 'listeevents', targetEntity: Donation::class, orphanRemoval: true)]
    private Collection $donations;



    public function __construct()
    {
        $this->sponsors = new ArrayCollection();
        $this->donations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getNomOrganisateur(): ?string
    {
        return $this->nom_organisateur;
    }

    public function setNomOrganisateur(string $nom_organisateur): self
    {
        $this->nom_organisateur = $nom_organisateur;

        return $this;
    }

    public function getEmailOrganisateur(): ?string
    {
        return $this->email_organisateur;
    }

    public function setEmailOrganisateur(string $email_organisateur): self
    {
        $this->email_organisateur = $email_organisateur;

        return $this;
    }

    public function getPhoneOrganisateur(): ?int
    {
        return $this->phone_organisateur;
    }

    public function setPhoneOrganisateur(int $phone_organisateur): self
    {
        $this->phone_organisateur = $phone_organisateur;

        return $this;
    }

    public function getDateDebut(): ?string
    {
        return $this->date_debut;
    }

    public function setDateDebut(string $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?string
    {
        return $this->date_fin;
    }

    public function setDateFin(string $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getMontantRecole(): ?int
    {
        return $this->montant_recole;
    }

    public function setMontantRecole(int $montant_recole): self
    {
        $this->montant_recole = $montant_recole;

        return $this;
    }


    public function getTypeEvenement(): ?TypeEvenement
    {
        return $this->typeEvenement;
    }

    public function setTypeEvenement(?TypeEvenement $typeEvenement): self
    {
        $this->typeEvenement = $typeEvenement;

        return $this;
    }

    /**
     * @return Collection<int, Donation>
     */
    public function getDonations(): Collection
    {
        return $this->donations;
    }

    public function addDonation(Donation $donation): self
    {
        if (!$this->donations->contains($donation)) {
            $this->donations->add($donation);
            $donation->setListeevents($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): self
    {
        if ($this->donations->removeElement($donation)) {
            // set the owning side to null (unless already changed)
            if ($donation->getListeevents() === $this) {
                $donation->setListeevents(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}