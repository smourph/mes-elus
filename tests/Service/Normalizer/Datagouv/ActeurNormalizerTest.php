<?php

namespace App\Tests\Service\Normalizer\Datagouv;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Entity\Datagouv\Acteur\EtatCivil;
use App\Entity\Datagouv\Acteur\Profession;
use App\Service\Normalizer\AbstractApiEntityNormalizer;
use App\Service\Normalizer\Datagouv\ActeurNormalizer;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class ActeurNormalizerTest.
 */
class ActeurNormalizerTest extends TestCase
{
    /**
     * @var ActeurNormalizer
     */
    private $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new ActeurNormalizer();
    }

    public function testInterface(): void
    {
        $this->assertInstanceOf(AbstractApiEntityNormalizer::class, $this->normalizer);
    }

    public function testSupportsNormalization(): void
    {
        $this->assertFalse($this->normalizer->supportsNormalization(new stdClass()));
        $this->assertTrue($this->normalizer->supportsNormalization(new Acteur()));
    }

    public function testSupportsDenormalization(): void
    {
        $this->assertFalse($this->normalizer->supportsDenormalization(null, stdClass::class));
        $this->assertFalse(
            $this->normalizer->supportsDenormalization(['acteur' => ['uid' => ['#text' => 'uid1']]], stdClass::class)
        );
        $this->assertTrue(
            $this->normalizer->supportsDenormalization(['acteur' => ['uid' => ['#text' => 'uid1']]], Acteur::class)
        );
        $this->assertFalse($this->normalizer->supportsDenormalization(['uid' => ['#text' => 'uid1']], Acteur::class));
        $this->assertFalse($this->normalizer->supportsDenormalization(['uid' => 'uid1'], Acteur::class));
    }

    /**
     * @throws ExceptionInterface
     */
    public function testDenormalize(): void
    {
        /** @var Acteur $object */
        $object = $this->normalizer->denormalize(
            [
                'acteur' => [
                    'uid' => [
                        '#text' => 'uid1',
                    ],
                    'etatCivil' => new EtatCivil(),
                    'profession' => new Profession(),
                ],
            ],
            Acteur::class
        );

        $this->assertInstanceOf(Acteur::class, $object);

        $this->assertEquals('uid1', $object->getUid());
        $this->assertEquals(new EtatCivil(), $object->getEtatCivil());
        $this->assertEquals(new Profession(), $object->getProfession());
    }
}
