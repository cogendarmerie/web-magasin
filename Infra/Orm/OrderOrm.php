<?php

namespace Infra\Orm;

use Domain\Order;
use Infra\Orm;

class OrderOrm extends Orm
{
    public function __construct()
    {
        parent::__construct("orders");
    }

    /**
     * Récupérer toutes les commandes
     * @return array
     */
    public function getAll()
    {
        $o = parent::findAll();
        $orders = array();

        foreach ($o as $order) {
            $orders[] = new Order($order);
        }

        return $orders;
    }

    /**
     * Sauvegrader la commande dans la base de donnée
     * @param Order $order
     * @return void
     */
    public function save(Order $order): void
    {
        $sql = "INSERT INTO " . $this->tableName . " (id, customer_id, order_date) VALUES (:id, :customerId, :orderDate)";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            'id' => $order->getId(),
            'customerId' => $order->getCustomer()->getId(),
            'orderDate' => $order->getDateCommande()->format('Y-m-d')
        ]);

        if(!$result)
        {
            throw new \Exception("Une erreur est survenue lors de l'enregistrement de la réservation.");
        }

        foreach ($order->getProducts() as $product)
        {
            $sql = "INSERT INTO orders_product (order_id, product_id, quantity) VALUES (:orderId, :productId, :quantity)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'orderId' => $order->getId(),
                'productId' => $product->getId(),
                'quantity' => $product->getQuantity()
            ]);
        }
    }
}