<?php

namespace Infra\Database;

use Domain\Commande;
use Infra\DatabaseInterface;
use Infra\DatabaseRepository;
use Domain\Client;
use Infra\Factory\ProduitFactory;

class CommandeRepository extends DatabaseRepository implements DatabaseInterface
{
    protected string $table = 'commande';

    public function findAll(): array
    {
        $sql = "SELECT commande.*, client.nom AS client_nom, client.email AS client_email FROM $this->table LEFT JOIN client ON commande.client_id = client.id ORDER BY commande.commande_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $commandes = array();

        foreach ($data as $commande)
        {
            $client = new Client(
                nom: $commande['client_email'],
                email: $commande['client_email'],
                id: $commande['client_id']
            );

            $commandes[] = new Commande(
                id: $commande['id'],
                client: $client,
                dateCommande: new \DateTime($commande['commande_date'])
            );
        }

        return $commandes;
    }

    public function findOneById(string $id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "id" => $id
        ]);
        $data = $stmt->fetch();
        $commande = new Commande(
            id: $data['id'],
            client: (new ClientRepository())->findOneById($data['client_id']),
            dateCommande: new \DateTime($data['commande_date'])
        );

        // Récupérer les articles
        $sql = "SELECT commande_produit.quantite, produit.id, produit.nom, produit.prix, produit.categorie, produit.date_expiration, produit.guarantie, produit.taille FROM commande_produit LEFT JOIN produit ON commande_produit.produit_id = produit.id WHERE commande_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "id" => $id
        ]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($data as $item)
        {
            // Créer le produit et l'ajouter à la commande
            $product = ProduitFactory::create(...$item);
            $commande->addProduct($product);
        }

        return $commande;
    }

    public function update(string $id, object $object)
    {
        if (!$object instanceof Commande)
        {
            throw new \InvalidArgumentException("Vous devez fournir une instance de commande.");
        }

        // Supprimer les produits
        $sql = "DELETE FROM commande_produit WHERE commande_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        // Ajouter les produits
        foreach ($object->getProducts() as $produit)
        {
            $sql = "INSERT INTO commande_produit (commande_id, produit_id, quantite) VALUES (:id, :produit_id, :quantite)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":produit_id", $produit->getId());
            $stmt->bindValue(":quantite", $produit->getQuantite());
            $stmt->execute();
        }
    }

    public function insert(object $object)
    {
        // TODO: Implement insert() method.
    }

    public function delete(string $id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Retourne un tableau contenant les commandes effectuées par un client
     * @param Client $customer
     * @return array
     */
    public function getCustomerOrders(Client $customer): array
    {
        $sql = "SELECT * FROM $this->table WHERE client_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $customer->getId());
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $orders = array();
        foreach ($data as $order)
        {
            $orders[] = new Commande(
                id: $order['id'],
                customer: $customer,
                dateCommande: new \DateTime($order['commande_date'])
            );
        }

        return $orders;
    }
}