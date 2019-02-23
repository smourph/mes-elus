<?php

namespace App\Tests\Entity\Datagouv\Acteur;

use App\Entity\Datagouv\Acteur\Ident;
use PHPUnit\Framework\TestCase;

/**
 * Class IdentTest.
 */
class IdentTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $ident = new Ident();

        $ident->setCiv('civ1');
        $this->assertEquals('civ1', $ident->getCiv());

        $ident->setPrenom('prenom1');
        $this->assertEquals('prenom1', $ident->getPrenom());

        $ident->setNom('nom1');
        $this->assertEquals('nom1', $ident->getNom());

        $ident->setAlpha('alpha1');
        $this->assertEquals('alpha1', $ident->getAlpha());
    }

    public function testNullableAttributes(): void
    {
        $ident = new Ident();

        $ident->setCiv(null);
        $this->assertNull($ident->getCiv());

        $ident->setPrenom(null);
        $this->assertNull($ident->getPrenom());

        $ident->setNom(null);
        $this->assertNull($ident->getNom());

        $ident->setAlpha(null);
        $this->assertNull($ident->getAlpha());
    }
}
