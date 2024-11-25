<?php
namespace Infra\Factory;

use Domain\Produit;
use Domain\Produit\Alimentaire;
use Domain\Produit\Electromenager;
use Domain\Produit\Textile;
use DateTime;
use InvalidArgumentException;

class ProduitFactory
{
    /**
     * Crée un produit en fonction de la catégorie
     *
     * @param string $id Identifiant du produit
     * @param string $nom Nom du produit
     * @param float|int $prix Prix du produit
     * @param int $quantite Quantité du produit
     * @param string $categorie Catégorie du produit
     * @param mixed $additionalData Données supplémentaires spécifiques à la catégorie
     * @return Produit
     * @throws InvalidArgumentException Si la catégorie n'est pas reconnue
     */
    public static function create(string $id, string $nom, float|int $prix, int $quantite, string $categorie, ?string $taille, ?DateTime $guarantie, ?DateTime $date_expiration): Produit
    {
        switch ($categorie) {
            case 'Alimentaire':
                return new Alimentaire(
                    id: $id,
                    nom: $nom,
                    prix: $prix,
                    quantite: $quantite,
                    categorie: $categorie,
                    dateExpiration: $date_expiration
                );
            case 'Electromenager':
                return new Electromenager(
                    id: $id,
                    nom: $nom,
                    prix: $prix,
                    quantite: $quantite,
                    categorie: $categorie,
                    guarantie: $guarantie
                );

            case 'Textile':
                return new Textile(
                    id: $id,
                    nom: $nom,
                    prix: $prix,
                    quantite: $quantite,
                    categorie: $categorie,
                    taille: $taille
                );

            default:
                throw new InvalidArgumentException('Catégorie de produit inconnue.');
        }
    }
}