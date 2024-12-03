<?php

namespace Controllers;

use Domain\Commande;
use Domain\Product\Alimentaire;
use Infra\Database\CommandeRepository;
use Infra\Database\ProduitRepository;
use Infra\Orm\CustomerOrm;
use Infra\Orm\OrderOrm;
use Infra\Orm\ProductOrm;

class OrdersController extends AbstractController
{
    protected OrderOrm $orm;
    protected CustomerOrm $customerOrm;
    protected ProductOrm $productOrm;
    protected CommandeRepository $ordersRepository;
    protected ProduitRepository $produitRepository;

    public function __construct()
    {
        parent::__construct();
        $this->orm = new OrderOrm();
        $this->customerOrm = new CustomerOrm();
        $this->productOrm = new ProductOrm();
        $this->ordersRepository = new CommandeRepository();
        $this->produitRepository = new ProduitRepository();
    }

    public function index(): void
    {
        $orders = $this->ordersRepository->findAll();
        $this->display('order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    public function details(string $orderId): void
    {
        try {
            $order = $this->ordersRepository->findOneById($orderId);
        } catch (\Exception $exception) {
            echo "Une erreur est survenue : " . $exception->getMessage();
            exit();
        }

        $this->display('order/details.html.twig', [
            'order' => $order
        ]);
    }

    public function create(): void
    {
        $customer = $this->customerOrm->getById("2b112f70-6da8-4783-bd1c-017af916bed1");
        var_dump($customer);

        $tshirt =  $this->productOrm->get("2618a984-235d-49e8-8222-bfb39644fc7d");
        $fraises = $this->productOrm->get("5eb106b8-053e-4c81-955d-4ba366170751");

        $products = [$tshirt, $fraises];
        var_dump($products);

        // Créer la commande
        $commande = new Commande(
            client: $customer
        );

        // Ajouter les articles
        $commande->addProducts($products);
        var_dump($commande);

        // Enregistrer la commande
        $this->orm->save($commande);
    }

    public function addProductToOrder(string $orderId): void
    {
        $commande = $this->ordersRepository->findOneById($orderId);
        $produits = $this->produitRepository->findAll();

        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if (!isset($_POST['produit']))
            {
                throw new \Exception("Veuillez fournir l'id du produit");
            }

            $produit = $this->produitRepository->findOneById($_POST['produit']);
            $commande->addProduct($produit);

            $this->ordersRepository->update($commande->getId(), $commande);
        }

        $this->display('order/add_product_to_order.html.twig', [
            'produits' => $produits
        ]);
    }
}