<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;


#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
    {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Champ vide")]

    #[Assert\Positive(message:"doit etre poitive")]

    private ?int $QteC = null;


    #[ORM\Column(length: 255)]
    private ?string $status = "a trate";




#[ORM\Column(length: 255)]
    #[Assert\Date]
    #[Assert\NotBlank(message:"Champ vide")]
    private ?string $date_ajout = null  ;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Champ vide")]
    private ?string $date_cloture = null;

    #[Assert\NotBlank(message:"Champ vide")]
    #[Assert\Length(min: 5 ,max: 7) ]

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motif_cloture = null;

    #[ORM\Column(nullable: true)]
    private ?int $prixC = null;

    #[ORM\ManyToOne(inversedBy: 'commandelist')]

    private ?Articles $articles = null;










    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQteC(): ?int
    {
        return $this->QteC;
    }

    public function setQteC(int $QteC): self
    {
        $this->QteC = $QteC;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDateAjout(): ?string
    {
        return $this->date_ajout;
    }

    public function setDateAjout(string $date_ajout): self
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }

    public function getDateCloture(): ?string
    {
        return $this->date_cloture;
    }

    public function setDateCloture(?string $date_cloture): self
    {
        $this->date_cloture = $date_cloture;

        return $this;
    }

    public function getMotifCloture(): ?string
    {
        return $this->motif_cloture;
    }

    public function setMotifCloture(?string $motif_cloture): self
    {
        $this->motif_cloture = $motif_cloture;

        return $this;
    }

    public function getArticles(): ?Articles
    {
        return $this->articles;
    }

    public function setArticles(?Articles $articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function getPrixC(): ?int
    {
        return $this->prixC;
    }

    public function setPrixC(?int $prixC): self
    {
        $this->prixC = $prixC;

        return $this;
    }





}
