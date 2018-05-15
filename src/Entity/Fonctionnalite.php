<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FonctionnaliteRepository")
 */
class Fonctionnalite
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priorite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projet", inversedBy="fonctionnalites")
     */
    private $projet;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserStory", mappedBy="fonctionnalite")
     */
    private $user_stories;

    public function __construct()
    {
        $this->user_stories = new ArrayCollection();
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

    public function getPriorite(): ?int
    {
        return $this->priorite;
    }

    public function setPriorite(?int $priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * @return Collection|UserStory[]
     */
    public function getUserStories(): Collection
    {
        return $this->user_stories;
    }

    public function addUserStory(UserStory $userStory): self
    {
        if (!$this->user_stories->contains($userStory)) {
            $this->user_stories[] = $userStory;
            $userStory->setFonctionnalite($this);
        }

        return $this;
    }

    public function removeUserStory(UserStory $userStory): self
    {
        if ($this->user_stories->contains($userStory)) {
            $this->user_stories->removeElement($userStory);
            // set the owning side to null (unless already changed)
            if ($userStory->getFonctionnalite() === $this) {
                $userStory->setFonctionnalite(null);
            }
        }

        return $this;
    }
}
