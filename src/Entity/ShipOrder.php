<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShipOrderRepository")
 */
class ShipOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="shipOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderPerson;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shippingName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shippingAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shippingCity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shippingCountry;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="shipOrder", orphanRemoval=true)
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getOrderPerson(): ?Person
    {
        return $this->orderPerson;
    }

    public function setOrderPerson(?Person $orderPerson): self
    {
        $this->orderPerson = $orderPerson;

        return $this;
    }

    public function getShippingName(): ?string
    {
        return $this->shippingName;
    }

    public function setShippingName(string $shippingName): self
    {
        $this->shippingName = $shippingName;

        return $this;
    }

    public function getShippingAddress(): ?string
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(string $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    public function getShippingCity(): ?string
    {
        return $this->shippingCity;
    }

    public function setShippingCity(string $shippingCity): self
    {
        $this->shippingCity = $shippingCity;

        return $this;
    }

    public function getShippingCountry(): ?string
    {
        return $this->shippingCountry;
    }

    public function setShippingCountry(string $shippingCountry): self
    {
        $this->shippingCountry = $shippingCountry;

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setShipOrder($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getShipOrder() === $this) {
                $item->setShipOrder(null);
            }
        }

        return $this;
    }
}
