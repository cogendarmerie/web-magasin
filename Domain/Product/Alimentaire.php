<?php

namespace Domain\Product;

use Domain\Product;

class Alimentaire extends Product
{
    public function __construct(float|int $price, string $name, int $quantity, protected \DateTime $dateExpiration, ?string $id = null)
    {
        parent::__construct(id: $id, price: $price, name: $name, category: "Alimentaire", quantity: $quantity);

        if(!$this->validateDateUlterieur())
        {
            throw new \Exception("La date limite de consommation est déjà passée, vous ne pouvez pas ajouter ce produit.");
        }
    }

    public function getDateExpiration(): \DateTime
    {
        return $this->dateExpiration;
    }

    /**
     * Vérifier si la date est dans le futur
     * @return bool
     */
    private function validateDateUlterieur(): bool
    {
        return new \DateTime() < $this->dateExpiration;
    }
}