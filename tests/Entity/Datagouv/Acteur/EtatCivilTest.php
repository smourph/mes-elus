<?php

namespace App\Tests\Entity\Datagouv\Acteur;

use App\Entity\Datagouv\Acteur\EtatCivil;
use App\Entity\Datagouv\Acteur\Ident;
use App\Entity\Datagouv\Acteur\InfoNaissance;
use DateTime;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EtatCivilTest.
 */
class EtatCivilTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $etatCivil = new EtatCivil();

        $etatCivil->setIdent(new Ident());
        $this->assertEquals(new Ident(), $etatCivil->getIdent());

        $etatCivil->setInfoNaissance(new InfoNaissance());
        $this->assertEquals(new InfoNaissance(), $etatCivil->getInfoNaissance());

        $etatCivil->setDateDeces(new DateTime('2001-01-01'));
        $this->assertEquals(new DateTime('2001-01-01'), $etatCivil->getDateDeces());
    }

    public function testNullableAttributes(): void
    {
        $etatCivil = new EtatCivil();

        $this->expectException(TypeError::class);
        $etatCivil->setIdent(null);

        $this->expectException(TypeError::class);
        $etatCivil->setInfoNaissance(null);

        $etatCivil->setDateDeces(null);
        $this->assertNull($etatCivil->getDateDeces());
    }
}
