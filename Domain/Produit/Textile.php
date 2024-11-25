<?php

namespace Domain\Produit;

use Domain\Produit;

class Textile extends Produit
{
    protected string $taille;

    public function __construct(string $nom, float|int $prix, int $quantite, string $categorie, string $taille, ?string $id = null)
    {
        parent::__construct($id, $nom, $prix, $quantite, $categorie);
        $this->taille = $taille;
    }

    public function getTaille(): string
    {
        return $this->taille;
    }
}