<?php

namespace Infra\Database;

use Domain\Order;
use Infra\DatabaseInterface;
use Infra\DatabaseRepository;
use Domain\Customer;

class OrdersRepository extends DatabaseRepository implements DatabaseInterface
{

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function findOneById(string $id)
    {
        // TODO: Implement findOneById() method.
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
     * @param Customer $customer
     * @return array
     */
    public function getCustomerOrders(Customer $customer): array
    {
        $sql = "SELECT * FROM orders WHERE customer_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $customer->getId());
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $orders = array();
        foreach ($data as $order)
        {
            $orders[] = new Order(
                id: $order['id'],
                customer: $customer,
                dateCommande: new \DateTime($order['order_date'])
            );
        }

        return $orders;
    }
}