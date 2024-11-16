<?php

namespace Domain;

use Infra\Uuid;

class Commande
{
    protected string $id;

    public function __construct(
        ?string             $id = null,
        protected Customer  $client,
        protected \DateTime $dateCommande,
        protected array     $products
    )
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getClient(): Customer
    {
        return $this->client;
    }
}