<?php

namespace Domain\Product;

use Domain\Product;

class Electromenager extends Product
{
    public function __construct(float|int $price, string $name, int $quantity, protected \DateTime $guarantee, ?string $id = null)
    {
        parent::__construct(id: $id, price: $price, name: $name, category: "Electromenager", quantity: $quantity);
    }

    /**
     * Retourne la date d'éxpiration de la garantie du produit
     * @return \DateTime
     */
    public function getGuarantee(): \DateTime
    {
        return $this->guarantee;
    }

    /**
     * Retourne si le produit est encore sous garantit
     * @return bool
     */
    public function isGuarantee(): bool
    {
        return $this->guarantee > new \DateTime();
    }

    /**
     * Terminer la garantit du produit
     * @return $this
     */
    public function stopGuarantee(): Electromenager
    {
        if(!$this->isGuarantee())
        {
            throw new \Exception("Le produit n'est déjà plus sous garantit");
        }

        $this->guarantee = new \DateTime();
        return $this;
    }

    /**
     * Ajoute 2 ans supplémentaire à la garantit
     * @return $this
     */
    public function augmenteGuarantee(): Electromenager
    {
        $this->guarantee->add(new \DateInterval('P2Y'));
        return $this;
    }
}