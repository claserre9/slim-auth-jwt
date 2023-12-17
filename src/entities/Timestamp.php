<?php

namespace App\entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait Timestamp
 *
 * This trait provides functionality for managing the timestamps of when an entity is created and updated.
 */
trait Timestamp
{

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $createdAt = null;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $updatedAt = null;


    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     */
    public function setCreatedAt(?DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     */
    public function setUpdatedAt(?DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }



    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate()
     */
    public function setAutoDate(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new DateTime();
        }
        $this->updatedAt = new DateTime();
    }
}
