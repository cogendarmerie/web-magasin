<?php

namespace Infra\Orm;

use Domain\Customer;
use Infra\Orm;
use PDO;

class CustomerOrm extends Orm
{
    public function __construct()
    {
        parent::__construct('customer');
    }

    /**
     * Récupérer tous les clients
     * @return array
     * @throws \Exception
     */
    public function getAll(): array
    {
        $customers = $this->findAll();
        $table = array();
        foreach ($customers as $customer)
        {
            $table[] = new \Domain\Customer(
                id: $customer['id'],
                name: $customer['name'],
                email: $customer['email']
            );
        }
        return $table;
    }

    /**
     * Récupérer un client par son id
     * @param string $id
     * @return Customer|null
     * @throws \Exception
     */
    public function getById(string $id): ?Customer
    {
        $customer = $this->find($id);
        return new Customer(
            id: $customer['id'],
            name: $customer['name'],
            email: $customer['email']
        );
    }

    /**
     * Ajouter un client dans la base de donnée
     * @param Customer $customer
     * @return bool
     */
    public function insert(Customer $customer): bool
    {
        return $this->create($customer->toArray());
    }

    /**
     * Supprimer un client
     * @param string $id
     * @return bool
     */
    public function remove(string $id): bool
    {
        return $this->delete($id);
    }
}