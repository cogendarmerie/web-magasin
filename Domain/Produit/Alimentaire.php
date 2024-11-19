<?php

namespace Domain\Produit;

use Domain\Produit;

class Alimentaire extends Produit
{
    protected \DateTime $dateExpiration;

    public function __construct(string $id, string $nom, float|int $prix, int $quantite, string $categorie, \DateTime $dateExpiration)
    {
        parent::__construct($id, $nom, $prix, $quantite, $categorie);
        $this->dateExpiration = $dateExpiration;
    }

    public function getDateExpiration(): \DateTime
    {
        return $this->dateExpiration;
    }

    /**
     * Retourne si le produit est périmée
     * @return bool True: Le produit est périmée, False: Le produit est viable
     */
    public function isPerimee(): bool
    {
        return new \DateTime() > $this->dateExpiration;
    }
}