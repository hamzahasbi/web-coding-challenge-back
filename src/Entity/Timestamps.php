<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Trait Timestamps
 * @package App\Entity
 */
trait Timestamps
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\PrePersist()
     */
    public function createdAt()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updateAt()
    {
        $this->updatedAt = new \DateTime();
    }
}