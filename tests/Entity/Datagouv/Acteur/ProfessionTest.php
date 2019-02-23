<?php

namespace App\Tests\Entity\Datagouv\Acteur;

use App\Entity\Datagouv\Acteur\Profession;
use App\Entity\Datagouv\Acteur\SocProcInsee;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class ProfessionTest.
 */
class ProfessionTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $profession = new Profession();

        $profession->setLibelleCourant('libelle1');
        $this->assertEquals('libelle1', $profession->getLibelleCourant());

        $profession->setSocProcINSEE(new SocProcInsee());
        $this->assertEquals(new SocProcInsee(), $profession->getSocProcINSEE());
    }

    public function testNullableAttributes(): void
    {
        $profession = new Profession();

        $profession->setLibelleCourant(null);
        $this->assertNull($profession->getLibelleCourant());

        $this->expectException(TypeError::class);
        $profession->setSocProcINSEE(null);
    }
}
