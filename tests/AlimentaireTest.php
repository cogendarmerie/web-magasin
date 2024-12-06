<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Domain\Produit\Alimentaire;

class AlimentaireTest extends TestCase
{
    /**
     * Vérification de la méthode de test de date de péremption pour une date future
     * @return void
     */
    public function testIsPerimeeFutureDate()
    {
        // Date dans le futur
        $futureDate = new \DateTime("2050-10-15");
        $fraise = new Alimentaire(
            nom: "Fraise",
            prix: 10.50,
            quantite: 10,
            dateExpiration: $futureDate
        );

        // Vérification de la méthode isPerimee
        $this->assertFalse($fraise->isPerimee(), "Les fraises ne sont pas encore périmées.");
    }

    /**
     * Vérification de la méthode de test de date de péremption pour une date passée
     * @return void
     */
    public function testIsPerimeePastDate()
    {
        // Date dans le passé
        $pastDate = new \DateTime("2000-10-15");
        $macaron = new Alimentaire(
            nom: "Macaron",
            prix: 10.00,
            quantite: 10,
            dateExpiration: $pastDate
        );

        // Vérification de la méthode isPerimee
        $this->assertTrue($macaron->isPerimee(), "Les macarons sont périmés.");
    }
}