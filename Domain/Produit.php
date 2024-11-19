<?php

namespace Domain;
class Produit
{
    protected string $id;
    protected string $nom;
    protected int $prix;
    protected int $quantite;
    protected string $categorie;

    public function __construct(string $id, string $nom, int|float $prix, int $quantite, string $categorie)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prix = gettype($prix) === 'integer' ? $prix : $prix * 100;
        $this->quantite = $quantite;
        $this->categorie = $categorie;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrix(): float
    {
        return $this->prix / 100;
    }

    public function getQuantite(): int
    {
        return $this->quantite;
    }

    public function getCategorie(): string
    {
        return $this->categorie;
    }

    /**
     * Retourne si le produit est en disponible
     * @return bool True: Le produit est disponible, False: Le produit n'est pas disponible actuellement
     */
    public function isAvailable(): bool
    {
        return $this->quantite > 0;
    }
}