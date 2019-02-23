<?php

namespace App\Tests\Entity\Datagouv\Acteur;

use App\Entity\Datagouv\Acteur\InfoNaissance;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Class InfoNaissanceTest.
 */
class InfoNaissanceTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $infoNaissance = new InfoNaissance();

        $infoNaissance->setDateNais(new DateTime('2001-01-01'));
        $this->assertEquals(new DateTime('2001-01-01'), $infoNaissance->getDateNais());

        $infoNaissance->setVilleNais('ville1');
        $this->assertEquals('ville1', $infoNaissance->getVilleNais());

        $infoNaissance->setDepNais('dep1');
        $this->assertEquals('dep1', $infoNaissance->getDepNais());

        $infoNaissance->setPaysNais('pays1');
        $this->assertEquals('pays1', $infoNaissance->getPaysNais());
    }

    public function testNullableAttributes(): void
    {
        $infoNaissance = new InfoNaissance();

        $infoNaissance->setDateNais(null);
        $this->assertNull($infoNaissance->getDateNais());

        $infoNaissance->setVilleNais(null);
        $this->assertNull($infoNaissance->getVilleNais());

        $infoNaissance->setDepNais(null);
        $this->assertNull($infoNaissance->getDepNais());

        $infoNaissance->setPaysNais(null);
        $this->assertNull($infoNaissance->getPaysNais());
    }
}
