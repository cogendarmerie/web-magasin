<?php

namespace Infra\Database;

use Domain\Customer;
use Infra\DatabaseInterface;
use Infra\DatabaseRepository;

class CustomerRepository extends DatabaseRepository implements DatabaseInterface
{

    /**
     * Retourne un tableau contenant les clients
     * @return array
     * @throws \Exception
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM customer";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $customers = array();
        foreach ($data as $customer) {
            $customers[] = new Customer(
                name: $customer['name'],
                email: $customer['email'],
                id: $customer['id']
            );
        }
        return $customers;
    }

    /**
     * Retourne un objet Customer ou null si aucun client trouver
     * @param string $id
     * @return Customer|null
     * @throws \Exception
     */
    public function findOneById(string $id): ?Customer
    {
        $sql = "SELECT * FROM customer WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(is_null($data))
        {
            return null;
        }

        return new Customer(
            name: $data['name'],
            email: $data['email'],
            id: $data['id']
        );
    }

    /**
     * Met à jour un client, retourne l'objet modifier
     * @param string $id
     * @param object $object
     * @return Customer
     * @throws \Exception
     */
    public function update(string $id, object $object): bool
    {
        if(!$object instanceof Customer) {
            throw new \Exception("Need instance of Customer");
        }

        $sql = "UPDATE customer SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":name", $object->getName());
        $stmt->bindValue(":email", $object->getEmail());
        return $stmt->execute();
    }

    public function insert(object $object): bool
    {
        if(!$object instanceof Customer) {
            throw new \Exception("Need instance of Customer");
        }

        $sql = "INSERT INTO customer (id, name, email) VALUES (:id, :name, :email)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $object->getId());
        $stmt->bindValue(":name", $object->getName());
        $stmt->bindValue(":email", $object->getEmail());
        return $stmt->execute();
    }

    public function delete(string $id): bool
    {
        $sql = "DELETE FROM customer WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }
}