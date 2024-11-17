<?php

namespace Infra\Orm;

use Domain\Product;
use Infra\Orm;

class ProductOrm extends Orm
{
    public function __construct()
    {
        parent::__construct("product");
    }

    /**
     * Insérer un produit dans la base de donnée
     * @param Product $product
     * @return bool
     */
    public function insert(Product $product): bool
    {
        $p = $product->toArray();
        return $this->create($p);
    }

    /**
     * Retourne la liste des articles
     * @return array
     * @throws \DateMalformedStringException
     */
    public function getAll(): array
    {
        $products = $this->findAll();
        $array = array();

        foreach ($products as $product)
        {
            $productFactory = new Product\ProductFactory();
            $array[] = $productFactory->createProduct($product['category'], $product);
        }

        return $array;
    }

    public function get(string $id): Product\Electromenager|Product\Alimentaire|Product\Textile|null
    {
        $productFactory = new Product\ProductFactory();
        $product = $this->find($id);
        return $productFactory->createProduct($product['category'], $product);
    }
}