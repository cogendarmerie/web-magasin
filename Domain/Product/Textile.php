<?php

namespace Domain\Product;

use Domain\Product;

class Textile extends Product
{
    public function __construct(?string $id, float|int $price, string $name, int $quantity, protected string $taille)
    {
        parent::__construct(id: $id, price: $price, name: $name, category: "textile", quantity: $quantity);
    }

    public function getTaille(): string
    {
        return $this->taille;
    }
}