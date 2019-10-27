<?php

namespace App\Tests\Entity\Datagouv\Acteur;

use App\Entity\Datagouv\Acteur\SocProcInsee;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class SocProcInseeTest.
 */
class SocProcInseeTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $socProcINSEE = new SocProcInsee();

        $socProcINSEE->setCatSocPro('cat1');
        $this->assertEquals('cat1', $socProcINSEE->getCatSocPro());

        $socProcINSEE->setFamSocPro('fam1');
        $this->assertEquals('fam1', $socProcINSEE->getFamSocPro());
    }

    public function testNullableAttributes(): void
    {
        $socProcINSEE = new SocProcInsee();

        $socProcINSEE->setCatSocPro(null);
        $this->assertNull($socProcINSEE->getCatSocPro());

        $this->expectException(TypeError::class);
        $socProcINSEE->setFamSocPro(null);
    }

    public function testUpdate(): void
    {
        $current = (new SocProcInsee())
            ->setCatSocPro('cat1')
            ->setFamSocPro('fam1');

        $new = (new SocProcInsee())
            ->setCatSocPro('cat2')
            ->setFamSocPro('fam2');

        $current->update($new);

        $this->assertEquals($new, $current);
    }
}
