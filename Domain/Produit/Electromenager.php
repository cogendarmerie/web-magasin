<?php

namespace Domain\Produit;

use DateTime;
use Domain\Produit;

class Electromenager extends Produit
{
    protected DateTime $guarantie;

    public function __construct(string $nom, float|int $prix, int $quantite, DateTime $guarantie, ?string $id = null)
    {
        parent::__construct(
            nom: $nom,
            prix: $prix,
            quantite: $quantite,
            categorie: "Electromenager",
            id: $id
        );
        $this->guarantie = $guarantie;
    }

    public function getGuarantie(): DateTime
    {
        return $this->guarantie;
    }

    /**
     * Retourne si le produit n'est plus sous garantit
     * @return bool True: Le produit n'est plus sous garantit, False: Le produit est encore sous garantit
     */
    public function isOutOfGuarantee(): bool
    {
        return new DateTime() > $this->guarantie;
    }

    /**
     * Arrête la guarantit du produit au jour dit
     * @return void
     */
    public function stopGuarantit()
    {
        $this->guarantie = new DateTime();
    }
}