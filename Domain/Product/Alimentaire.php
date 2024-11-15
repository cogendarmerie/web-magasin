<?php

namespace Domain\Product;

use Domain\Product;

class Alimentaire extends Product
{
    public function __construct(?string $id, float|int $price, string $name, int $quantity, protected \DateTime $dateExpiration)
    {
        parent::__construct(id: $id, price: $price, name: $name, category: "alimentaire", quantity: $quantity);

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