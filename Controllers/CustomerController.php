<?php

namespace Controllers;

use Domain\Customer;
use Infra\Orm\CustomerOrm;
use PDO;
use PDOException;

class CustomerController extends Controller
{
    /**
     * Lister les clients
     * @return void
     */
    public function index()
    {
        $customerOrm = new CustomerOrm();
        $customers = $customerOrm->getAll();

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
                $customer = new Customer(
                    name: $_POST['name'],
                    email: $_POST['email']
                );

                // Sauvegarder le client dans la base de donnée
                $customerOrm = new CustomerOrm();
                $resultCreation = $customerOrm->insert($customer);

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
     * Page détaillant une fiche client
     * @param $customerId
     * @return void
     */
    public function details($customerId)
    {
        $customerOrm = new CustomerOrm();
        $customer = $customerOrm->getById($customerId);

        $this->display('customer/details.html.twig', [
            'customer' => $customer
        ]);
    }
}