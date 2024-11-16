<?php

namespace Domain;

use Infra\Uuid;

abstract class Product
{
    protected string $id;
    protected int $price;

    public function __construct(
        int|float $price,
        protected string $name,
        protected string $category,
        protected int $quantity,
        ?string $id = null
    )
    {
        // Générer un uuid pour les nouveau objets
        $this->id = $id ?? Uuid::uuid4()->toString();
        (int) $this->price = gettype(($price)) === 'double' ? $price * 100 : $price;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price / 100;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Ajouter de nouvelles entrée stock
     * @param int $quantity
     * @return Product
     */
    public function entreeStock(int $quantity): Product
    {
        $this->quantity += $quantity;
        return $this;
    }

    /**
     * Retirer des articles des stocks
     * @param int $quantity
     * @return Product
     */
    public function sortieStock(int $quantity): Product
    {
        $this->quantity -= $quantity;
        return $this;
    }
}