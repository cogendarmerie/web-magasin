<?php

namespace Migrations;

use migrations;

class CreateOrderTable extends Migration
{
    public function up()
    {
        // Table order
        $sql = 'CREATE TABLE IF NOT EXISTS orders (id VARCHAR(255) PRIMARY KEY, customer_id VARCHAR(255) NOT NULL, order_date DATETIME NOT NULL)';
        $this->pdo->exec($sql);

        // Table relation order & products
        $sql = 'CREATE TABLE IF NOT EXISTS orders_product (order_id VARCHAR(255) NOT NULL, product_id VARCHAR(255) NOT NULL, quantity INT NOT NULL, PRIMARY KEY (order_id, product_id), FOREIGN KEY (order_id) REFERENCES order(id), FOREIGN KEY (product_id) REFERENCES product(id))';
        $this->pdo->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS order_product';
        $this->pdo->exec($sql);

        $sql = 'DROP TABLE IF EXISTS orders';
        $this->pdo->exec($sql);
    }
}