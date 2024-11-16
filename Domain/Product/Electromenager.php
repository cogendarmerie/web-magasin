<?php

namespace Domain\Product;

use Domain\Product;

class Electromenager extends Product
{
    public function __construct(float|int $price, string $name, int $quantity, protected \DateTime $guarantee, ?string $id = null)
    {
        parent::__construct(id: $id, price: $price, name: $name, category: "Electromenager", quantity: $quantity);
    }

    /**
     * Retourne la date d'éxpiration de la garantie du produit
     * @return \DateTime
     */
    public function getGuarantee(): \DateTime
    {
        return $this->guarantee;
    }

    private function checkGuarantee(): bool
    {
        return new \DateTime($this->guarantee) > new \DateTime();
    }
}