<?php

namespace tests;

use Domain\Product\Electromenager;
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
            price: 150.59,
            name: "Frigo Américain",
            quantity: 15,
            guarantee: new \DateTime("2050-10-15")
        );

        $this->assertTrue($frigo->isGuarantee(), "La garantit n'est pas encore dépassée.");
    }

    /**
     * Date de garantit dépassée
     * @return void
     */
    public function testGuaranteePastElectromenager()
    {
        $ordinateur = new Electromenager(
            price: 879.99,
            name: "DELL Optiplex 5060 Tiny",
            quantity: 15,
            guarantee: new \DateTime("2000-10-15")
        );

        $this->assertFalse($ordinateur->isGuarantee(), "La garantit de l'ordinateur est dépassée.");
    }
}