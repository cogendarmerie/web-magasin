<?php

namespace migrations;

class CreeTableProduit extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS produit (
            id VARCHAR(255) PRIMARY KEY,
            nom VARCHAR(255) NOT NULL,
            prix INT NOT NULL,
            quantite INT NOT NULL,
            categorie ENUM('Alimentaire', 'Electromenager', 'Textile') NOT NULL,
            date_expiration DATETIME NULL,
            guarantit DATETIME NULL,
            size VARCHAR(50) NULl
        )";
        $this->pdo->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS produit';
        $this->pdo->exec($sql);
    }
}