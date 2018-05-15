<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetRepository")
 */
class Projet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;
	
	/**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_image;

    

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groupe", inversedBy="projet")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupe;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fonctionnalite", mappedBy="projet")
     */
    private $fonctionnalites;

    public function __construct()
    {
        $this->fonctionnalites = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
	
	public function getIdImage(): ?int
    {
        return $this->id_image;
    }

    public function setIdImage(?int $id_image): self
    {
        $this->id_image = $id_image;

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * @return Collection|Fonctionnalite[]
     */
    public function getFonctionnalites(): Collection
    {
        return $this->fonctionnalites;
    }

    public function addFonctionnalite(Fonctionnalite $fonctionnalite): self
    {
        if (!$this->fonctionnalites->contains($fonctionnalite)) {
            $this->fonctionnalites[] = $fonctionnalite;
            $fonctionnalite->setProjet($this);
        }

        return $this;
    }

    public function removeFonctionnalite(Fonctionnalite $fonctionnalite): self
    {
        if ($this->fonctionnalites->contains($fonctionnalite)) {
            $this->fonctionnalites->removeElement($fonctionnalite);
            // set the owning side to null (unless already changed)
            if ($fonctionnalite->getProjet() === $this) {
                $fonctionnalite->setProjet(null);
            }
        }

        return $this;
    }
}
