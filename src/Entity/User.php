<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="The {{ value }} is already used."
 * )
 */
class User implements UserInterface, \serializable
{
    const ROLES = [
        'Admin' => "ROLE_ADMIN",
        'User' => 'ROLE_USER',
        'Customer' => 'ROLE_CUSTOMER'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="array")
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $roles = [];

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */

    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */

    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserDetails", inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="userDetails",referencedColumnName="id",nullable=true)
     */
    private $userdetails;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserTeam", mappedBy="user")
     */
    private $userTeams;

    public function __construct()
    {

        $this->isActive = true;
        $this->roles = ['ROLE_USER'];
        $this->createdAt = new \DateTime('@' . strtotime('now'));
        $this->updatedAt = new \DateTime('@' . strtotime('now'));
        $this->userTeams = new ArrayCollection();
    }


    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->isActive = true;
        $this->roles = ['ROLE_USER'];
        $this->createdAt = new \DateTime('@' . strtotime('now'));
        $this->updatedAt = new \DateTime('@' . strtotime('now'));
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }
        foreach ($roles as $role) {
            if (substr($role, 0, 5) !== 'ROLE_') {
                throw new InvalidArgumentException("Chaque rôle doit commencer par 'ROLE_'");
            }
        }
        $this->roles = $roles;
        return $this;
    }

    public function getSalt()
    {
        // pas besoin de salt puisque nous allons utiliser bcrypt
        // attention si vous utilisez une méthode d'encodage différente !
        // il faudra décommenter les lignes concernant le salt, créer la propriété correspondante, et renvoyer sa valeur dans cette méthode
        return null;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            $this->email,
            // voir remarques sur salt plus haut
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            $this->email,
            // voir remarques sur salt plus haut
            // $this->salt
            ) = unserialize($serialized);
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUserdetails(): ?UserDetails
    {
        return $this->userdetails;
    }

    public function setUserdetails(?UserDetails $userdetails): self
    {
        $this->userdetails = $userdetails;

        return $this;
    }

    /**
     * @return Collection|UserTeam[]
     */
    public function getUserTeams(): Collection
    {
        return $this->userTeams;
    }

    public function addUserTeam(UserTeam $userTeam): self
    {
        if (!$this->userTeams->contains($userTeam)) {
            $this->userTeams[] = $userTeam;
            $userTeam->setUser($this);
        }

        return $this;
    }

    public function removeUserTeam(UserTeam $userTeam): self
    {
        if ($this->userTeams->contains($userTeam)) {
            $this->userTeams->removeElement($userTeam);
            // set the owning side to null (unless already changed)
            if ($userTeam->getUser() === $this) {
                $userTeam->setUser(null);
            }
        }

        return $this;
    }
}
