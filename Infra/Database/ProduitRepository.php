<?php

namespace Infra\Database;

use Infra\DatabaseInterface;
use Infra\DatabaseRepository;
use Infra\Factory\ProduitFactory;
use PDO;

class ProduitRepository extends DatabaseRepository implements DatabaseInterface
{

    public function findAll()
    {
        $sql = "SELECT * FROM produit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $produits = array();
        foreach ($data as $item)
        {
            $produit = ProduitFactory::create(...$item);

            var_dump($produit);
            exit();
        }
    }

    public function findOneById(string $id)
    {
        $sql = "SELECT * FROM produits WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $type = $data['type'];
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
}