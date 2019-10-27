<?php

namespace App\Tests\Entity\Datagouv\Acteur;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Entity\Datagouv\Acteur\EtatCivil;
use App\Entity\Datagouv\Acteur\Ident;
use App\Entity\Datagouv\Acteur\InfoNaissance;
use App\Entity\Datagouv\Acteur\Profession;
use App\Entity\Datagouv\Acteur\SocProcInsee;
use DateTime;
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
        $this->assertEquals('uid1', $acteur->getId());
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

    public function testUpdate(): void
    {
        $old = (new Acteur())
            ->setUid('uid1')
            ->setEtatCivil(
                (new EtatCivil())
                    ->setIdent(
                        (new Ident())
                            ->setCiv('civ1')
                            ->setPrenom('prenom1')
                            ->setNom('nom1')
                            ->setAlpha('alpha1')
                    )
                    ->setInfoNaissance(
                        (new InfoNaissance())
                            ->setDateNais(new DateTime('2000-01-01'))
                            ->setVilleNais('ville1')
                            ->setDepNais('dep1')
                            ->setPaysNais('pays1')
                    )
                    ->setDateDeces(null)
            )
            ->setProfession(
                (new Profession())
                    ->setLibelleCourant('libelle1')
                    ->setSocProcINSEE(
                        (new SocProcInsee())
                            ->setCatSocPro('cat1')
                            ->setFamSocPro('fam1')
                    )
            );

        $new = (new Acteur())
            ->setUid('uid1')
            ->setEtatCivil(
                (new EtatCivil())
                    ->setIdent(
                        (new Ident())
                            ->setCiv('civ2')
                            ->setPrenom('prenom2')
                            ->setNom('nom2')
                            ->setAlpha('alpha2')
                    )
                    ->setInfoNaissance(
                        (new InfoNaissance())
                            ->setDateNais(new DateTime('2001-01-01'))
                            ->setVilleNais('ville2')
                            ->setDepNais('dep2')
                            ->setPaysNais('pays2')
                    )
                    ->setDateDeces(new DateTime('2100-01-01'))
            )
            ->setProfession(
                (new Profession())
                    ->setLibelleCourant('libelle2')
                    ->setSocProcINSEE(
                        (new SocProcInsee())
                            ->setCatSocPro('cat2')
                            ->setFamSocPro('fam2')
                    )
            );

        $this->assertNotEquals($new, $old);

        $this->assertEquals($new, $old->update($new));
    }
}
