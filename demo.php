<?php
require_once 'autoload.php';
require_once 'vendor/autoload.php';

// Création de produit de test
$ordinateur = new \Domain\Produit\Electromenager(
    nom: "DELL Optiplex 3060 Tiny",
    prix: 879.99,
    quantite: 1,
    guarantie: new DateTime("2050-10-15")
);
$fraise = new \Domain\Produit\Alimentaire(
    nom: "Barquette de Fraise",
    prix: 12.50,
    quantite: 5,
    dateExpiration: new DateTime("2050-10-15")
);
$tshirt = new \Domain\Produit\Textile(
    nom: "Tshirt",
    prix: 120.50,
    quantite: 4,
    taille: "M"
);

// Création d'un client
$customer = new \Domain\Client(
    nom: "John DOE",
    email: "johndoe@example.com"
);

// Création d'une commande
$order = new \Domain\Commande(
    client: $customer,
    dateCommande: new DateTime()
);

// Ajouter des produits dans la commande
// Via un tableau
$order->addProducts([
    $ordinateur,
    $fraise
]);

// A l'unite
$order->addProduct($tshirt);

// Affichage de la commande
echo "Commande : \n";
echo "Client : " . $order->getClient()->getNom() . " (". $order->getClient()->getEmail() .")\n";
echo "Nombre d'articles : " . $order->getNumberOfProducts() . "\n";
echo "Prix total : " . $order->getTotalPrice() . "\n";
echo "Date de commande : " . $order->getDateCommande()->format('Y-m-d') . "\n";
echo "Produits : \n";
foreach ($order->getProducts() as $product) {
    echo "- " . $product->getNom() . " (" . $product->getPrix() . "€)\n";
}