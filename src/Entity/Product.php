<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product implements \JsonSerializable
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
    private $barcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4)
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=true)
     */
    private $priceBought;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateAdded;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateUpdated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
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

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceBought()
    {
        return $this->priceBought;
    }

    public function setPriceBought($priceBought): self
    {
        $this->priceBought = $priceBought;

        return $this;
    }

    public function getDateAdded(): ?\DateTimeInterface
    {
        return $this->dateAdded;
    }

    public function setDateAdded(?\DateTimeInterface $dateAdded): self
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(?\DateTimeInterface $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'barcode'=>$this->barcode,
            'name'=> $this->name,
            'quantity'=>$this->quantity,
            'price'=>$this->price,
            'price'=>$this->priceBought,
            'date_added'=>$this->dateAdded->format('Y-m-d H:i:s'),
            'date_added'=>$this->dateUpdated->format('Y-m-d H:i:s'),
        );
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
