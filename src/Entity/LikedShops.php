<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikedShopsRepository")
 * @ORM\Table(name="liked_shop",
 *    uniqueConstraints={
 *        @ORM\UniqueConstraint(name="liked_shops_unique",
 *            columns={"shops_id", "user_id"})
 *    }
 * )
 */
class LikedShops
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Shop", inversedBy="lists")
     */
    private $shops;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="lists")
     */
    private $user;


    /**
     * LikedShops constructor.
     */
    public function __construct()
    {
        $this->shops = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param Shop $shop
     * @return LikedShops
     */
    public function addShop(Shop $shop): self
    {
        if (!$this->shops->contains($shop)) {
            $this->shops[] = $shop;
        }
        return $this;
    }

    /**
     * @param Shop $shop
     * @return LikedShops
     */
    public function removeShop(Shop $shop): self
    {
        if ($this->shops->contains($shop)) {
            $this->shops->removeElement($shop);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * @param mixed $shops
     * @return LikedShops
     */
    public function setShops($shops): self
    {
        $this->shops = $shops;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return LikedShops
     */
    public function setUser($user): self
    {
        $this->user = $user;
        return $this;
    }
}
