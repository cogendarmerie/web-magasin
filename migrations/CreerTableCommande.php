<?php

namespace Migrations;

use migrations;

class CreerTableCommande extends Migration
{
    public function up()
    {
        // Table order
        $sql = 'CREATE TABLE IF NOT EXISTS commande (id VARCHAR(255) PRIMARY KEY, client_id VARCHAR(255) NOT NULL, commande_date DATETIME NOT NULL)';
        $this->pdo->exec($sql);

        // Table relation order & products
        $sql = 'CREATE TABLE IF NOT EXISTS commande_produit (commande_id VARCHAR(255) NOT NULL, produit_id VARCHAR(255) NOT NULL, quantite INT NOT NULL, PRIMARY KEY (commande_id, produit_id), FOREIGN KEY (commande_id) REFERENCES commande(id), FOREIGN KEY (produit_id) REFERENCES produit(id))';
        $this->pdo->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS commande_produit';
        $this->pdo->exec($sql);

        $sql = 'DROP TABLE IF EXISTS commande';
        $this->pdo->exec($sql);
    }
}