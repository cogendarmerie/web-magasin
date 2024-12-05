<?php

namespace Domain;

use Infra\Uuid;

class Commande
{
    protected string $id;
    protected Client $client;
    protected \DateTime $dateCommande;
    protected array $products = array();

    public function __construct(
        ?string    $id = null,
        ?Client    $client = null,
        ?\DateTime $dateCommande = null,
    )
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
        $this->client = $client;
        $this->dateCommande = $dateCommande ?? new \DateTime();
    }

    /**
     * Retourne l'identifiant de la commande
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Retourne le client
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    public function getDateCommande(): \DateTime
    {
        return $this->dateCommande;
    }

    /**
     * Ajoute un produit à la commande
     * @param Produit $produit
     * @return $this
     */
    public function addProduct(Produit $produit): Commande
    {
        if(method_exists($produit, "isPerimee"))
        {
            // Checker la date de péremption
            if ($produit->isPerimee())
            {
                throw new \Exception("Impossible d'ajouter ce produit, car il est périmée.");
            }
        }

        // Vérifier le stock du produit
        if(!$produit->isAvailable())
        {
            throw new \Exception("Le produit n'est pas disponible.");
        }

        // Ajouter le produit
        $this->products[] = $produit;

//        $produit->sortieStock(1);

        return $this;
    }

    /**
     * Ajouter un tableau contenant des articles à la commande
     * @param array $products
     * @return $this
     * @throws \Exception
     */
    public function addProducts(array $products): Commande
    {
        foreach($products as $product)
        {
            $this->addProduct($product);
        }
        return $this;
    }

    /**
     * Retourne les articles contenu dans la commande
     * @return array Contient les articles
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function getTotalPrice(): float
    {
        $total = 0;
        foreach($this->products as $product)
        {
            $total += $product->getPrix();
        }
        return round($total, 2);
    }

    /**
     * Retourne le nombre d'article contenu dans la commande
     * @return int
     */
    public function getNumberOfProducts(): int
    {
        return count($this->products);
    }
}