<?php

namespace Infra\Database;

use Domain\Commande;
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
        $sql = "SELECT id, nom, prix, quantite, categorie, date_expiration, guarantie, taille FROM $this->tableName WHERE deleted_at IS NULL";
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

    /**
     * Retourne tous les produits contenu dans la base qui ne sont pas déjà ajoutée a une commande
     * @param Commande $commande
     * @return array
     * @throws \DateMalformedStringException
     */
    public function findAllNotContainedInOrder(Commande $commande): array
    {
        $sql = "
            SELECT p.id, p.nom, p.prix, p.quantite, p.date_expiration, p.guarantie, p.taille, p.categorie 
            FROM produit p 
            WHERE p.id NOT IN (
                SELECT cp.produit_id 
                FROM commande_produit cp 
                WHERE cp.commande_id = :id
            )
            AND p.deleted_at IS NULL
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $commande->getId()]);
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
        $sql = "SELECT id, nom, prix, quantite, categorie, date_expiration, guarantie, taille FROM $this->tableName WHERE id = ?";
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
        $sql = "UPDATE produit SET deleted_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}