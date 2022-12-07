<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomprenomm = null;

    #[ORM\Column(length: 255)]
    private ?string $adrm = null;

    #[ORM\OneToMany(mappedBy: 'med_id', targetEntity: Examen::class)]
    private Collection $med;

    public function __construct()
    {
        $this->med = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomprenomm(): ?string
    {
        return $this->nomprenomm;
    }

    public function setNomprenomm(string $nomprenomm): self
    {
        $this->nomprenomm = $nomprenomm;

        return $this;
    }

    public function getAdrm(): ?string
    {
        return $this->adrm;
    }

    public function setAdrm(string $adrm): self
    {
        $this->adrm = $adrm;

        return $this;
    }

    /**
     * @return Collection<int, Examen>
     */
    public function getMed(): Collection
    {
        return $this->med;
    }

    public function addMed(Examen $med): self
    {
        if (!$this->med->contains($med)) {
            $this->med->add($med);
            $med->setMedId($this);
        }

        return $this;
    }

    public function removeMed(Examen $med): self
    {
        if ($this->med->removeElement($med)) {
            // set the owning side to null (unless already changed)
            if ($med->getMedId() === $this) {
                $med->setMedId(null);
            }
        }

        return $this;
    }
}
