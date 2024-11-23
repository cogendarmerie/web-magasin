<?php

namespace Infra\Database;

use Infra\DatabaseInterface;
use Infra\DatabaseRepository;
use PDO;

class ProductRepository extends DatabaseRepository implements DatabaseInterface
{

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function findOneById(string $id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
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