<?php

namespace App\Tests\Entity\Datagouv\Acteur;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Entity\Datagouv\Acteur\EtatCivil;
use App\Entity\Datagouv\Acteur\Profession;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class ActeurTest.
 */
class ActeurTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $acteur = new Acteur();

        $acteur->setUid('uid1');
        $this->assertEquals('uid1', $acteur->getUid());

        $acteur->setEtatCivil(new EtatCivil());
        $this->assertEquals(new EtatCivil(), $acteur->getEtatCivil());

        $acteur->setProfession(new Profession());
        $this->assertEquals(new Profession(), $acteur->getProfession());
    }

    public function testNullableAttributes(): void
    {
        $acteur = new Acteur();

        $this->expectException(TypeError::class);
        $acteur->setUid(null);

        $this->expectException(TypeError::class);
        $acteur->setEtatCivil(null);

        $this->expectException(TypeError::class);
        $acteur->setProfession(null);
    }
}
