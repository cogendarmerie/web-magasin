<?php

namespace Domain;

use Infra\Uuid;

class Order
{
    protected string $id;
    protected Customer $customer;
    protected \DateTime $dateCommande;
    protected array $products;

    public function __construct(
        ?string $id = null,
        ?Customer $customer = null,
    )
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
        $this->customer = $customer;
        $this->dateCommande = new \DateTime();
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
     * @return Customer
     */
    public function getCustomer(): Customer
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
    public function addProduct(Product $product): Order
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

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}