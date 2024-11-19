<?php

namespace Domain;

use Infra\Orm\ProductOrm;
use Infra\Uuid;

abstract class Product
{
    private ProductOrm $orm;
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

        $this->orm = new ProductOrm();
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

    /**
     * Retourne si le produit est disponible
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->quantity > 0;
    }

    public function toArray(): array
    {
        $vars = get_object_vars($this);
        unset($vars['orm']);
        return $vars;
    }

    // Database
    public function find(): Product
    {
        $product = $this->orm->get($this->getId());
        $this->name = $product->getName();
        $this->price = $product->getPrice();
        $this->quantity = $product->getQuantity();
        return $this;
    }

    public function insert(): bool
    {
        return $this->orm->insert($this);
    }

    public function update(): bool
    {
        return $this->orm->update($this->getId(), $this->toArray());
    }

    public function delete(): bool
    {
        return $this->orm->delete($this->getId());
    }
}