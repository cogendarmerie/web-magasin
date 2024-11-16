<?php

namespace Domain\Product;

use Domain\Product;

class Textile extends Product
{
    public function __construct(float|int $price, string $name, int $quantity, protected string $size, ?string $id = null)
    {
        parent::__construct(id: $id, price: $price, name: $name, category: "Textile", quantity: $quantity);
    }

    public function getSize(): string
    {
        return $this->size;
    }
}