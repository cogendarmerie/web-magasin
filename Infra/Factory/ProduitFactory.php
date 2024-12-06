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
     * Créer un objet produit selon son type
     * @param string $id
     * @param string $nom
     * @param float|int $prix
     * @param int $quantite
     * @param string $categorie
     * @param string|null $taille
     * @param DateTime|string|null $guarantie
     * @param DateTime|string|null $date_expiration
     * @return Produit
     * @throws \DateMalformedStringException
     */
    public static function create(string $nom, float|int $prix, int $quantite, string $categorie, ?string $taille, null|DateTime|string $guarantie, null|DateTime|string $date_expiration, ?string $id = null): Produit
    {
        if ($prix < 0)
        {
            throw new InvalidArgumentException("Le prix ne peux être négatif.");
        }

        switch ($categorie) {
            case 'Alimentaire':
                if (is_null($date_expiration))
                {
                    throw new InvalidArgumentException("La date expiration n'est pas valide.");
                }

                return new Alimentaire(
                    nom: $nom,
                    prix: $prix,
                    quantite: $quantite,
                    dateExpiration: $date_expiration instanceof DateTime ? $date_expiration : new DateTime($date_expiration),
                    id: $id
                );

            case 'Electromenager':
                if (is_null($guarantie))
                {
                    throw new InvalidArgumentException("La date de guarantie est requise.");
                }

                return new Electromenager(
                    nom: $nom,
                    prix: $prix,
                    quantite: $quantite,
                    guarantie: $guarantie instanceof DateTime ? $guarantie : new DateTime($guarantie),
                    id: $id
                );

            case 'Textile':
                return new Textile(
                    nom: $nom,
                    prix: $prix,
                    quantite: $quantite,
                    taille: $taille,
                    id: $id
                );

            default:
                throw new InvalidArgumentException('Catégorie de produit inconnue.');
        }
    }
}