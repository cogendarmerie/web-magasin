<?php

namespace Infra\Database;

use Domain\Produit;
use Infra\DatabaseInterface;
use Infra\DatabaseRepository;
use Infra\Factory\ProduitFactory;
use PDO;

class ProduitRepository extends DatabaseRepository implements DatabaseInterface
{
    protected string $tableName = 'produit';

    public function findAll(): array
    {
        $sql = "SELECT * FROM $this->tableName";
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
        $sql = "SELECT * FROM $this->tableName WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return ProduitFactory::create(...$data);
    }

    public function update(string $id, object $object): bool
    {
        $sql = "UPDATE $this->tableName SET
                nom = :nom,
                prix = :prix,
                quantite = :quantite,
                categorie = :categorie,
                taille = :taille,
                guarantie = :guarantie,
                date_expiration = :date_expiration
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':nom', $object->getNom());
        $stmt->bindValue(':prix', $object->getPrix());
        $stmt->bindValue(':quantite', $object->getQuantite());
        $stmt->bindValue(':categorie', $object->getCategorie());
        $stmt->bindValue(':taille', $object->getTaille() ?? null);
        $stmt->bindValue(':guarantie', $object->getGuarantie() ? $object->getGuarantie()->format('Y-m-d') : null);
        $stmt->bindValue(':date_expiration', $object->getDateExpiration() ? $object->getDateExpiration()->format('Y-m-d') : null);

        return $stmt->execute();
    }

    public function insert(object $object): bool
    {
        $sql = "INSERT INTO $this->tableName (id, nom, prix, quantite, categorie, taille, guarantie, date_expiration)
                VALUES (:id, :nom, :prix, :quantite, :categorie, :taille, :guarantie, :date_expiration)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $object->getId());
        $stmt->bindValue(':nom', $object->getNom());
        $stmt->bindValue(':prix', $object->getPrixInt());
        $stmt->bindValue(':quantite', $object->getQuantite());
        $stmt->bindValue(':categorie', $object->getCategorie());
        $stmt->bindValue(':taille', method_exists(get_class($object), "getTaille") ? $object->getTaille() : null);
        $stmt->bindValue(':guarantie', method_exists(get_class($object), "getGuarantee") ? $object->getGuarantie()->format('Y-m-d') : null);
        $stmt->bindValue(':date_expiration', method_exists(get_class($object), "getDateExpiration") ? $object->getDateExpiration()->format('Y-m-d') : null);

        return $stmt->execute();
    }

    public function delete(string $id): bool
    {
        $sql = "DELETE FROM $this->tableName WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}