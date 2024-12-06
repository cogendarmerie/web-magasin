<?php

namespace tests;

use Domain\Produit\Electromenager;
use PHPUnit\Framework\TestCase;

class ElectromenagerTest extends TestCase
{
    /**
     * Date de garantit pas encore passée
     * @return void
     */
    public function testGuaranteeFuturElectromenager()
    {
        $frigo = new Electromenager(
            nom: "Frigo Américain",
            prix: 150.59,
            quantite: 15,
            guarantie: new \DateTime("2050-10-15")
        );

        $this->assertFalse($frigo->isOutOfGuarantee(), "La garantit n'est pas encore dépassée.");
    }

    /**
     * Date de garantit dépassée
     * @return void
     */
    public function testGuaranteePastElectromenager()
    {
        $ordinateur = new Electromenager(
            nom: "DELL Optiplex 5060 Tiny",
            prix: 879.99,
            quantite: 15,
            guarantie: new \DateTime("2000-10-15")
        );

        $this->assertTrue($ordinateur->isOutOfGuarantee(), "La garantit de l'ordinateur est dépassée.");
    }
}