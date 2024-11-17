<?php

namespace Domain\Product;

use Domain\Product;

class Alimentaire extends Product
{
    public function __construct(float|int $price, string $name, int $quantity, protected \DateTime $dateExpiration, ?string $id = null)
    {
        parent::__construct(id: $id, price: $price, name: $name, category: "Alimentaire", quantity: $quantity);
    }

    public function getDateExpiration(): \DateTime
    {
        return $this->dateExpiration;
    }

    /**
     * Vérifier si la date est dans le futur
     * @return bool
     */
    public function isPerimee(): bool
    {
        return new \DateTime() > $this->dateExpiration;
    }
}