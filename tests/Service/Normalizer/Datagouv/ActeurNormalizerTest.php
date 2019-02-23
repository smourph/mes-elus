<?php

namespace App\Tests\Service\Normalizer\Datagouv;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Entity\Datagouv\Acteur\EtatCivil;
use App\Entity\Datagouv\Acteur\Profession;
use App\Service\Normalizer\Datagouv\ActeurNormalizer;
use PHPUnit\Framework\TestCase;

/**
 * Class ActeurNormalizerTest.
 */
class ActeurNormalizerTest extends TestCase
{
    public function testSupportsNormalization(): void
    {
        $normalizer = new ActeurNormalizer();

        $this->assertFalse($normalizer->supportsNormalization(new \stdClass()));
        $this->assertTrue($normalizer->supportsNormalization(new Acteur()));
    }

    public function testSupportsDenormalization(): void
    {
        $normalizer = new ActeurNormalizer();

        $this->assertFalse($normalizer->supportsDenormalization(null, \stdClass::class));
        $this->assertTrue($normalizer->supportsDenormalization(['uid' => ['#text' => 'uid1']], Acteur::class));
        $this->assertFalse($normalizer->supportsDenormalization(['uid' => 'uid1'], Acteur::class));
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function testDenormalize(): void
    {
        $normalizer = new ActeurNormalizer();

        $object = $normalizer->denormalize(
            [
                'uid' => [
                    '#text' => 'uid1',
                ],
                'etatCivil' => new EtatCivil(),
                'profession' => new Profession(),
            ],
            Acteur::class
        );

        $this->assertInstanceOf(Acteur::class, $object);

        $this->assertObjectHasAttribute('uid', $object);
        $this->assertEquals('uid1', $object->getUid());

        $this->assertObjectHasAttribute('etatCivil', $object);
        $this->assertEquals(new EtatCivil(), $object->getEtatCivil());

        $this->assertObjectHasAttribute('profession', $object);
        $this->assertEquals(new Profession(), $object->getProfession());
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function testWrongFormat(): void
    {
        $normalizer = new ActeurNormalizer();

        $this->expectException(\PHPUnit\Framework\Exception::class);
        $this->expectExceptionMessage('Illegal string offset \'#text\'');
        $object = $normalizer->denormalize(
            [
                'uid' => 'uid1',
                'etatCivil' => new EtatCivil(),
                'profession' => new Profession(),
            ],
            Acteur::class
        );
    }
}
