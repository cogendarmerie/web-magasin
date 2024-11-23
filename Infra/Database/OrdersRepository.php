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
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "id" => $id
        ]);
        $data = $stmt->fetch();
        $order = new Order(
            id: $data['id'],
            customer: (new CustomerRepository())->findOneById($data['customer_id']),
            dateCommande: new \DateTime($data['order_date'])
        );

        // Récupérer les articles
        $sql = "SELECT orders_product.quantity, product.id, product.name, product.price, product.category, product.date_expiration, product.guarantee, product.size FROM orders_product LEFT JOIN product ON orders_product.product_id = product.id WHERE order_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "id" => $id
        ]);
        $data = $stmt->fetchAll();
        $classBase = "\\Domain\\Produit\\";
        foreach ($data as $item)
        {
            $class = $classBase . $item['category'];
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