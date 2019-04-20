<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserGroupRepository")
 */
class UserGroup
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="groupUser")
     */
    private $allUsers;

    public function __construct()
    {
        $this->allUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAllUsers(): Collection
    {
        return $this->allUsers;
    }

    public function addAllUser(User $allUser): self
    {
        if (!$this->allUsers->contains($allUser)) {
            $this->allUsers[] = $allUser;
            $allUser->addGroupUser($this);
        }

        return $this;
    }

    public function removeAllUser(User $allUser): self
    {
        if ($this->allUsers->contains($allUser)) {
            $this->allUsers->removeElement($allUser);
            $allUser->removeGroupUser($this);
        }

        return $this;
    }
}
