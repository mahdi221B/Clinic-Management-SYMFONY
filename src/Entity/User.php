<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface ;
#[ORM\Entity(repositoryClass: UserRepository::class)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[Assert\NotNull]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: 'Your first name must be at least {{ limit }} characters long',
        maxMessage: 'Your first name cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $Nom = null;


    #[Assert\NotNull]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: 'Your last name must be at least {{ limit }} characters long',
        maxMessage: 'Your last name cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[Assert\NotNull]
    #[ORM\Column(length: 255)]
    private ?string $Sexe = null;

    #[Assert\NotNull]
    #[Assert\Length(
        min: 8,
        max: 8,
        minMessage: 'Your number   must be at least {{ limit }} numbers  long',
        maxMessage: 'Your number   cannot be longer than {{ limit }} numbers ',
    )]
    #[ORM\Column]
    private ?int $NumTel = null;



    #[Assert\NotNull]
    #[Assert\Length(
        min: 8,
        max: 9,
        minMessage: 'Your CIN must be at least {{ limit }} number long',
        maxMessage: 'Your CIN cannot be longer than {{ limit }} numbers',
    )]
    #[ORM\Column]
    private ?int $Cin = null;



    #[Assert\NotNull]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[ORM\Column(length: 255)]
    private ?string $Adresse = null;

    #[Assert\NotNull]
    #[Assert\Length(
        min: 6,
        max: 50,
        minMessage: 'Your password must be at least {{ limit }} number long',
        maxMessage: 'Your password cannot be longer than {{ limit }} numbers',
    )]
    #[ORM\Column(length: 255)]
    private ?string $MotPasse = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Absence::class)]
    private Collection $absences;

    #[Assert\NotNull]
    #[ORM\Column(length: 255)]
    private ?string $Role = null;

    #[ORM\Column]
    private ?bool $enabled = true;


    public function __construct()
    {
        $this->absences = new ArrayCollection();
    }


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

    public function getSexe(): ?string
    {
        return $this->Sexe;
    }

    public function setSexe(string $Sexe): self
    {
        $this->Sexe = $Sexe;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->NumTel;
    }

    public function setNumTel(int $NumTel): self
    {
        $this->NumTel = $NumTel;

        return $this;
    }

    public function getCin(): ?int
    {
        return $this->Cin;
    }

    public function setCin(int $Cin): self
    {
        $this->Cin = $Cin;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getMotPasse(): ?string
    {
        return $this->MotPasse;
    }

    public function setMotPasse(string $MotPasse): self
    {
        $this->MotPasse = $MotPasse;

        return $this;
    }

    /**
     * @return Collection<int, Absence>
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): self
    {
        if (!$this->absences->contains($absence)) {
            $this->absences->add($absence);
            $absence->setUser($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getUser() === $this) {
                $absence->setUser(null);
            }
        }

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): self
    {
        $this->Role = $Role;

        return $this;
    }


    public function getRoles():array
    {
        $roles = (array) $this->getRole();
        return $roles;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
        return (string) $this->Adresse;
    }

    public function getPassword(): ?string
    {
        return $this->getMotPasse() ;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
    public function getUsername()
    {
        return $this->Adresse;
    }

    public function getSalt()
    {
        // you may need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
}