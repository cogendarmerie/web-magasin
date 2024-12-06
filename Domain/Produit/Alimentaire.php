<?php

namespace Domain\Produit;

use Domain\Produit;

class Alimentaire extends Produit
{
    protected \DateTime $dateExpiration;

    public function __construct( string $nom, float|int $prix, int $quantite, \DateTime $dateExpiration, ?string $id = null)
    {
        parent::__construct(
            nom: $nom,
            prix: $prix,
            quantite: $quantite,
            categorie: "Alimentaire",
            id: $id
        );
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