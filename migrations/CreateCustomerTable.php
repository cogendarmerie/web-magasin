<?php

namespace migrations;

class CreateCustomerTable extends Migration
{
    public function up()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS customer (id VARCHAR(255) PRIMARY KEY, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL)';
        $this->pdo->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS customer';
        $this->pdo->exec($sql);
    }
}