<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupeRepository")
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombre_participants;

    public function getId()
    {
        return $this->id;
    }

    public function getNombreParticipants(): ?int
    {
        return $this->nombre_participants;
    }

    public function setNombreParticipants(?int $nombre_participants): self
    {
        $this->nombre_participants = $nombre_participants;

        return $this;
    }
}
