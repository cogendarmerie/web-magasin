<?php

namespace Domain\Product;

use Domain\Product;

class Electromenager extends Product
{
    public function __construct(?string $id, float|int $price, string $name, string $category, int $quantity, protected \DateTime $guarantee)
    {
        parent::__construct(id: $id, price: $price, name: $name, category: $category, quantity: $quantity);
    }

    /**
     * Retourne la date d'éxpiration de la garantie du produit
     * @return \DateTime
     */
    public function getGuarantee(): \DateTime
    {
        return $this->guarantee;
    }
}