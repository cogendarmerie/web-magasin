<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Domain\Product\Alimentaire;

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
            name: "Fraise",
            price: 10.50,
            dateExpiration: $futureDate,
            quantity: 10
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
            name: "Macaron",
            price: 10.00,
            dateExpiration: $pastDate,
            quantity: 10
        );

        // Vérification de la méthode isPerimee
        $this->assertTrue($macaron->isPerimee(), "Les macarons sont périmés.");
    }
}