<?php

namespace Infra\Database;

use Domain\Client;
use Infra\DatabaseInterface;
use Infra\DatabaseRepository;

class ClientRepository extends DatabaseRepository implements DatabaseInterface
{

    /**
     * Retourne un tableau contenant les clients
     * @return array
     * @throws \Exception
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM client";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $customers = array();
        foreach ($data as $customer) {
            $customers[] = new Client(
                nom: $customer['nom'],
                email: $customer['email'],
                id: $customer['id']
            );
        }
        return $customers;
    }

    /**
     * Retourne un objet Client ou null si aucun client trouver
     * @param string $id
     * @return Client|null
     * @throws \Exception
     */
    public function findOneById(string $id): ?Client
    {
        $sql = "SELECT * FROM client WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(is_null($data))
        {
            return null;
        }

        return new Client(
            nom: $data['nom'],
            email: $data['email'],
            id: $data['id']
        );
    }

    /**
     * Met à jour un client, retourne l'objet modifier
     * @param string $id
     * @param object $object
     * @return Client
     * @throws \Exception
     */
    public function update(string $id, object $object): bool
    {
        if(!$object instanceof Client) {
            throw new \Exception("Need instance of Client");
        }

        $sql = "UPDATE client SET nom = :nom, email = :email WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":nom", $object->getNom());
        $stmt->bindValue(":email", $object->getEmail());
        return $stmt->execute();
    }

    public function insert(object $object): bool
    {
        if(!$object instanceof Client) {
            throw new \Exception("Need instance of Client");
        }

        $sql = "INSERT INTO client (id, nom, email) VALUES (:id, :nom, :email)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $object->getId());
        $stmt->bindValue(":nom", $object->getNom());
        $stmt->bindValue(":email", $object->getEmail());
        return $stmt->execute();
    }

    public function delete(string $id): bool
    {
        $sql = "DELETE FROM client WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }
}