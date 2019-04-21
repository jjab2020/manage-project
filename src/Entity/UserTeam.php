<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserTeamRepository")
 */
class UserTeam
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userTeams")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="userTeams")
     */
    private $team;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }


    public function setDate($date): void
    {
        $this->date = $date;
    }
}
