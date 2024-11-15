<?php

namespace migrations;

class CreateProductTable extends Migration
{
    public function up()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS product (id VARCHAR(255) PRIMARY KEY, name VARCHAR(255) NOT NULL, price INT NOT NULL, quantity INT NOT NULL, category VARCHAR(255))';
        $this->pdo->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS product';
        $this->pdo->exec($sql);
    }
}