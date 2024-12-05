<?php

namespace migrations;

class CreerTableClient extends Migration
{
    public function up()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS client (id VARCHAR(255) PRIMARY KEY, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL)';
        $this->pdo->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS client';
        $this->pdo->exec($sql);
    }
}