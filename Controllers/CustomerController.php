<?php

namespace Controllers;

use Domain\Client;
use Domain\Commande;
use Infra\Database\ClientRepository;
use Infra\Database\CommandeRepository;
use Infra\Orm\CustomerOrm;
use PDO;
use PDOException;

class CustomerController extends AbstractController
{
    protected ClientRepository $repository;
    protected CommandeRepository $ordersRepository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new ClientRepository();
        $this->ordersRepository = new CommandeRepository();
    }

    /**
     * Lister les clients
     * @return void
     */
    public function index()
    {
        $customers = $this->repository->findAll();

        $this->display('customer/index.html.twig', [
            'customers' => $customers
        ]);
    }

    public function create()
    {
        // Envoie du formulaire
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            try
            {
                // Réception des données et création de la fiche client
                $customer = new Client(
                    nom: $_POST['nom'],
                    email: $_POST['email']
                );

                // Sauvegarder le client dans la base de donnée
                $resultCreation = $this->repository->insert($customer);

                if($resultCreation)
                {
                    // Redirigée l'utilisateur
                    $this->redirect('/customers');
                }
                else
                {
                    echo "Une erreur est survenue lors de l'enregistrement.";
                    exit();
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
                exit();
            }
        }

        $this->display('customer/create.html.twig');
    }

    /**
     * Supprimer un client
     * @return void
     */
    public function delete(): void
    {
        if(!isset($_GET['customerId']))
        {
            echo "Vous devez fournir un id client";
            exit();
        }

        $customerId = $_GET['customerId'];

        // Supprimer le client
        $deletion = $this->repository->delete($customerId);

        if($deletion)
        {
            $this->redirect('/customers');
        }
        else
        {
            echo "Une erreur est survenue lors de la suppression.";
        }
    }

    /**
     * Page détaillant une fiche client
     * @param $customerId
     * @return void
     */
    public function details($customerId)
    {
        $customer = $this->repository->findOneById($customerId);

        $orders = $this->ordersRepository->getCustomerOrders($customer);

        $this->display('customer/details.html.twig', [
            'customer' => $customer,
            'orders' => $orders
        ]);
    }
}