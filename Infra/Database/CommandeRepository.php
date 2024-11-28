<?php

namespace Infra\Database;

use Domain\Commande;
use Infra\DatabaseInterface;
use Infra\DatabaseRepository;
use Domain\Client;

class CommandeRepository extends DatabaseRepository implements DatabaseInterface
{

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function findOneById(string $id)
    {
        $sql = "SELECT * FROM commande WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "id" => $id
        ]);
        $data = $stmt->fetch();
        $order = new Commande(
            id: $data['id'],
            customer: (new ClientRepository())->findOneById($data['customer_id']),
            dateCommande: new \DateTime($data['date_commande'])
        );

        // Récupérer les articles
        $sql = "SELECT commande_produit.quantity, produit.id, produit.name, produit.price, produit.category, produit.date_expiration, produit.guarantee, produit.size FROM commande_produit LEFT JOIN produit ON commande_produit.produit_id = produit.id WHERE commande_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "id" => $id
        ]);
        $data = $stmt->fetchAll();
        $classBase = "\\Domain\\Produit\\";
        foreach ($data as $item)
        {
            $class = $classBase . $item['categorie'];
            $reflexionClass = new \ReflectionClass($class);
            $constructorParams = $reflexionClass->getConstructor()->getParameters();

            $params = array();
            foreach ($constructorParams as $param)
            {
                $paramName = $param->getName();
                if(isset($item[$paramName]))
                {
                    array_push($params, $item[$paramName]);
                }
            }

            var_dump($item);
            exit();

            $product = new $class(...$params);
            var_dump($product);
            exit();
        }

        return $order;
    }

    public function update(string $id, object $object)
    {
        // TODO: Implement update() method.
    }

    public function insert(object $object)
    {
        // TODO: Implement insert() method.
    }

    public function delete(string $id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Retourne un tableau contenant les commandes effectuées par un client
     * @param Client $customer
     * @return array
     */
    public function getCustomerOrders(Client $customer): array
    {
        $sql = "SELECT * FROM commande WHERE client_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $customer->getId());
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $orders = array();
        foreach ($data as $order)
        {
            $orders[] = new Commande(
                id: $order['id'],
                customer: $customer,
                dateCommande: new \DateTime($order['commande_date'])
            );
        }

        return $orders;
    }
}