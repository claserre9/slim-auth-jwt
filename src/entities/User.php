<?php

namespace App\entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements \JsonSerializable
{
    use Timestamp;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="json")
     */
    private array $role = ['ROLE_USER'];


    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private bool $isActive = false;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $activationToken = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $activationTokenExpiryDate = null;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $passwordResetToken = null;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $passwordResetTokenExpiryDate = null;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $profilePicture;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return array
     */
    public function getRole(): array
    {
        return $this->role;
    }

    /**
     * @param array $role
     * @return User
     */
    public function setRole(array $role): User
    {
        $role = array_unique([...$this->role, ...$role]);
        $this->role = $role;
        return $this;
    }


    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return User
     */
    public function setIsActive(bool $isActive): User
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(string $profilePicture): User
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }


    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }


    public function setActivationToken(?string $activationToken): User
    {
        $this->activationToken = $activationToken;
        return $this;
    }


    public function getActivationTokenExpiryDate(): ?int
    {
        return $this->activationTokenExpiryDate;
    }

    public function setActivationTokenExpiryDate(?int $activationTokenExpiryDate): User
    {
        $this->activationTokenExpiryDate = $activationTokenExpiryDate;
        return $this;
    }


    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }


    public function setPasswordResetToken(?string $passwordResetToken): User
    {
        $this->passwordResetToken = $passwordResetToken;
        return $this;
    }


    public function getPasswordResetTokenExpiryDate(): ?int
    {
        return $this->passwordResetTokenExpiryDate;
    }


    public function setPasswordResetTokenExpiryDate(?int $passwordResetTokenExpiryDate): User
    {
        $this->passwordResetTokenExpiryDate = $passwordResetTokenExpiryDate;
        return $this;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'isActive' => $this->isActive,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}