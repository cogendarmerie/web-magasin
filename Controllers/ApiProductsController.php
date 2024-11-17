<?php

namespace Controllers;

use Infra\Orm\ProductOrm;

class ApiProductsController extends ApiController
{
    protected ProductOrm $orm;

    public function __construct()
    {
        $this->orm = new ProductOrm();
    }

    public function guaranteeStop()
    {
        if(!isset($_GET['product_id']))
        {
            $this->error("Vous devez fournir un 'product_id'.", 400);
        }

        try {
            // Récupérer l'id de guarantit
            $productId = $_GET['product_id'];

            // Récupérer le produit
            $product = $this->orm->get($productId);

            // Product Type
            if(!method_exists($product, 'getGuarantee'))
            {
                throw new \Exception("Ce produit ne bénéficie pas de garantit.");
            }

            // Stoper la guarantit du produit
            $product->stopGuarantee();

            // Sauvegarder la modification en BDD
            $this->orm->update($product->getId(), [
                "guarantee" => $product->getGuarantee()
            ]);
        } catch (\Exception $e) {
            $this->error("Impossible d'arrêter la garantie : " . $e->getMessage(), 500);
        }

        $this->json([
            "ok" => true,
            "product" => $product->toArray()
        ]);
    }
}