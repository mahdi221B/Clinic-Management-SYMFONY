<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;
use http\Message;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\NotBlank(message:"champ vide")]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: 'the  name must be at least {{ limit }} characters long',
        maxMessage: 'the  name cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $nomPat = null;
    #[Assert\NotBlank(message:"champ vide")]

    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: 'the  name must be at least {{ limit }} characters long',
        maxMessage: 'the  name cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $nomMedecin = null;
    #[Assert\NotBlank(message:"champ vide")]

    #[Assert\Length(
        min: 5,
        max: 40,
        minMessage: 'the  medication list must be at least {{ limit }} characters long',
        maxMessage: 'the  medication list cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $listMedic = null;
    #[Assert\NotBlank(message:"champ vide")]
    #[Assert\Length(
        min: 5,
        max: 40,
        minMessage: 'the  exam list must be at least {{ limit }} characters long',
        maxMessage: 'the  exam list cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $listExam = null;
    #[Assert\NotBlank(message:"champ vide")]

    #[Assert\Length(
        min: 5,
        max: 40,
        minMessage: 'the  colum of treatement must be at least {{ limit }} characters long',
        maxMessage: 'the  colum of treatement list cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $traitement = null;
    #[Assert\NotBlank(message:"champ vide")]

    #[ORM\Column(length: 255)]
    private ?string $dateCons = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPat(): ?string
    {
        return $this->nomPat;
    }

    public function setNomPat(string $nomPat): self
    {
        $this->nomPat = $nomPat;

        return $this;
    }

    public function getNomMedecin(): ?string
    {
        return $this->nomMedecin;
    }

    public function setNomMedecin(string $nomMedecin): self
    {
        $this->nomMedecin = $nomMedecin;

        return $this;
    }

    public function getListMedic(): ?string
    {
        return $this->listMedic;
    }

    public function setListMedic(string $listMedic): self
    {
        $this->listMedic = $listMedic;

        return $this;
    }

    public function getListExam(): ?string
    {
        return $this->listExam;
    }

    public function setListExam(string $listExam): self
    {
        $this->listExam = $listExam;

        return $this;
    }

    public function getTraitement(): ?string
    {
        return $this->traitement;
    }

    public function setTraitement(string $traitement): self
    {
        $this->traitement = $traitement;

        return $this;
    }

    public function getDateCons(): ?string
    {
        return $this->dateCons;
    }

    public function setDateCons(string $dateCons): self
    {
        $this->dateCons = $dateCons;

        return $this;
    }

}
