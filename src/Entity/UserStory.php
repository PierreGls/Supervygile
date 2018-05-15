<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserStoryRepository")
 */
class UserStory
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
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $echeance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fonctionnalite", inversedBy="user_stories")
     */
    private $fonctionnalite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tache", mappedBy="userStory")
     */
    private $taches;

    
    public function __construct()
    {
        $this->taches = new ArrayCollection();
        
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

    public function getEcheance(): ?\DateTimeImmutable
    {
        return $this->echeance;
    }

    public function setEcheance(?\DateTimeImmutable $echeance): self
    {
        $this->echeance = $echeance;

        return $this;
    }

    public function getFonctionnalite(): ?Fonctionnalite
    {
        return $this->fonctionnalite;
    }

    public function setFonctionnalite(?Fonctionnalite $fonctionnalite): self
    {
        $this->fonctionnalite = $fonctionnalite;

        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches[] = $tach;
            $tach->setUserStory($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): self
    {
        if ($this->taches->contains($tach)) {
            $this->taches->removeElement($tach);
            // set the owning side to null (unless already changed)
            if ($tach->getUserStory() === $this) {
                $tach->setUserStory(null);
            }
        }

        return $this;
    }

    
}
