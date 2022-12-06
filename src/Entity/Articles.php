<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class   Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]

    private ?string $nom_articles = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Champ vide")]
    #[Assert\Positive(message:"doit etre poitive")]

    private ?int $qte = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Champ vide")]
    #[Assert\Length(min: 10)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Champ vide")]

    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Champ vide")]

    private ?string $a_qui_destine = null;



    #[ORM\Column]
    #[Assert\NotBlank(message:"Champ vide")]
#[Assert\Positive(message:"doit etre poitive")]

    private ?int $prix ;

    #[ORM\OneToMany(mappedBy: 'articles', targetEntity: Commande::class)]
    private Collection $commandelist;

    public function __construct()
    {
        $this->commandelist = new ArrayCollection();
    }







    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomArticles(): ?string
    {
        return $this->nom_articles;
    }

    public function setNomArticles(string $nom_articles): self
    {
        $this->nom_articles = $nom_articles;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAQuiDestine(): ?string
    {
        return $this->a_qui_destine;
    }

    public function setAQuiDestine(string $a_qui_destine): self
    {
        $this->a_qui_destine = $a_qui_destine;

        return $this;
    }



    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandelist(): Collection
    {
        return $this->commandelist;
    }

    public function addCommandelist(Commande $commandelist): self
    {
        if (!$this->commandelist->contains($commandelist)) {
            $this->commandelist->add($commandelist);
            $commandelist->setArticles($this);
        }

        return $this;
    }

    public function removeCommandelist(Commande $commandelist): self
    {
        if ($this->commandelist->removeElement($commandelist)) {
            // set the owning side to null (unless already changed)
            if ($commandelist->getArticles() === $this) {
                $commandelist->setArticles(null);
            }
        }

        return $this;
    }




}
