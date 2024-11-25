<?php

namespace Infra\Database;

use Domain\Produit;
use Infra\DatabaseInterface;
use Infra\DatabaseRepository;
use Infra\Factory\ProduitFactory;
use PDO;

class ProduitRepository extends DatabaseRepository implements DatabaseInterface
{

    public function findAll(): array
    {
        $sql = "SELECT * FROM produit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $produits = array();
        foreach ($data as $item)
        {
            $produit = ProduitFactory::create(...$item);
            array_push($produits, $produit);
        }

        return $produits;
    }

    public function findOneById(string $id): Produit
    {
        $sql = "SELECT * FROM produits WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return ProduitFactory::create(...$data);
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