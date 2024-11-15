<?php
namespace Controllers;

use Domain\Product\Alimentaire;

class ProductsController extends Controller
{
    public function index(): void
    {
        $products = [];

        try {
            $products[] = new Alimentaire(price: 10.50, name: "Macaron", quantity: 3, dateExpiration: new \DateTime("2025-01-01"),  id: null);
            $products[] = new Alimentaire(price: 10.50, name: "Glace Pistache", quantity: 8, dateExpiration: new \DateTime("2025-01-04"),  id: null);
            $products[] = new Alimentaire(price: 10.50, name: "Macaron", quantity: 3, dateExpiration: new \DateTime("2025-01-01"),  id: null);
            $products[] = new Alimentaire(price: 10.50, name: "Glace Pistache", quantity: 8, dateExpiration: new \DateTime("2025-01-04"),  id: null);
            $products[] = new Alimentaire(price: 10.50, name: "Macaron", quantity: 3, dateExpiration: new \DateTime("2025-01-01"),  id: null);
            $products[] = new Alimentaire(price: 10.50, name: "Glace Pistache", quantity: 8, dateExpiration: new \DateTime("2025-01-04"),  id: null);
            $products[] = new Alimentaire(price: 10.50, name: "Macaron", quantity: 3, dateExpiration: new \DateTime("2025-01-01"),  id: null);
            $products[] = new Alimentaire(price: 10.50, name: "Glace Pistache", quantity: 8, dateExpiration: new \DateTime("2025-01-04"),  id: null);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $this->display('products/index.html.twig', [
            'products' => $products
        ]);
    }
}