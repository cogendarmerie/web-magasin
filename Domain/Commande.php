<?php

namespace Domain;

use Infra\Uuid;

class Commande
{
    protected string $id;
    protected Client $customer;
    protected \DateTime $dateCommande;
    protected array $products = array();

    public function __construct(
        ?string    $id = null,
        ?Client    $customer = null,
        ?\DateTime $dateCommande = null,
    )
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
        $this->customer = $customer;
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
    public function getCustomer(): Client
    {
        return $this->customer;
    }

    public function getDateCommande(): \DateTime
    {
        return $this->dateCommande;
    }

    /**
     * Ajoute un produit à la commande
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product): Commande
    {
        if(method_exists($product, "isPerimee"))
        {
            // Checker la date de péremption
            if ($product->isPerimee())
            {
                throw new \Exception("Impossible d'ajouter ce produit, car il est périmée.");
            }
        }

        // Vérifier le stock du produit
        if(!$product->isAvailable())
        {
            throw new \Exception("Le produit n'est pas disponible.");
        }

        $this->products[] = $product;
        $product->sortieStock(1);
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

    public function getTotalPrice(): int
    {
        $total = 0;
        foreach($this->products as $product)
        {
            $total += $product->getPrice();
        }
        return $total;
    }
}