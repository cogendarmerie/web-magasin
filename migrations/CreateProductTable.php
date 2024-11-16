<?php

namespace migrations;

class CreateProductTable extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS product (
            id VARCHAR(255) PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            price INT NOT NULL,
            quantity INT NOT NULL,
            category ENUM('Alimentaire', 'Electromenager', 'Textile') NOT NULL,
            date_expiration DATETIME NULL,
            guarantee DATETIME NULL,
            size VARCHAR(50) NULl
        )";
        $this->pdo->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS product';
        $this->pdo->exec($sql);
    }
}