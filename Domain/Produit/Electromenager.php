<?php

namespace Domain\Produit;

use DateTime;
use Domain\Produit;

class Electromenager extends Produit
{
    protected DateTime $guarantit;

    public function __construct(string $id, string $nom, float|int $prix, int $quantite, string $categorie, DateTime $guarantit)
    {
        parent::__construct($id, $nom, $prix, $quantite, $categorie);
        $this->guarantit = $guarantit;
    }

    public function getGuarantit(): DateTime
    {
        return $this->guarantit;
    }

    /**
     * Retourne si le produit n'est plus sous garantit
     * @return bool True: Le produit n'est plus sous garantit, False: Le produit est encore sous garantit
     */
    public function isOutOfGuarantee(): bool
    {
        return new DateTime() > $this->guarantit;
    }

    /**
     * Arrête la guarantit du produit au jour dit
     * @return void
     */
    public function stopGuarantit()
    {
        $this->guarantit = new DateTime();
    }
}