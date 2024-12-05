<?php

namespace Controllers;

use Domain\Commande;
use Domain\Product\Alimentaire;
use Infra\Database\ClientRepository;
use Infra\Database\CommandeRepository;
use Infra\Database\ProduitRepository;

class OrdersController extends AbstractController
{
    protected ClientRepository $clientRepository;
    protected CommandeRepository $ordersRepository;
    protected ProduitRepository $produitRepository;

    public function __construct()
    {
        parent::__construct();
        $this->clientRepository = new ClientRepository();
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // Formulaire soumis
            if(!isset($_POST['client']) or empty($_POST['client']))
            {
                throw new \Exception("Veuillez renseigner le champ Client");
            }

            if(!isset($_POST['date']) or empty($_POST['date']))
            {
                $_POST['date'] = new \DateTime();
            }
            else
            {
                $_POST['date'] = new \DateTime($_POST['date']);
            }

            $client = $this->clientRepository->findOneById($_POST['client']);
            $commande = new Commande(
                id: null,
                client: $client,
                dateCommande: $_POST['date']
            );

            // Enregistrer la commande dans la base de donnée
            $insertion = $this->ordersRepository->insert($commande);

            if($insertion)
            {
                $this->redirect("/orders/details/" . $commande->getId());
            }
            else
            {
                echo "Une erreur est survenue";
            }
            exit();
        }

        $clients = $this->clientRepository->findAll();

        $this->display('order/create.html.twig', [
            'clients' => $clients
        ]);
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

            $this->redirect("/orders/details/" . $commande->getId());
        }

        $this->display('order/add_product_to_order.html.twig', [
            'produits' => $produits
        ]);
    }
}