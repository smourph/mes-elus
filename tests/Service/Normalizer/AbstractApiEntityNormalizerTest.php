<?php

namespace App\Tests\Service\Normalizer;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Entity\Datagouv\Acteur\EtatCivil;
use App\Entity\Datagouv\Acteur\Ident;
use App\Entity\Datagouv\Acteur\InfoNaissance;
use App\Entity\Datagouv\Acteur\Profession;
use App\Entity\Datagouv\Acteur\SocProcInsee;
use App\Service\Normalizer\AbstractApiEntityNormalizer;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class AbstractApiEntityNormalizerTest.
 */
class AbstractApiEntityNormalizerTest extends TestCase
{
    /**
     * @var AbstractApiEntityNormalizer
     */
    private $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new AbstractApiEntityNormalizer();
    }

    public function testSupportsNormalization(): void
    {
        $this->assertFalse($this->normalizer->supportsNormalization(new stdClass()));
        $this->assertFalse($this->normalizer->supportsNormalization(new Acteur()));
        $this->assertFalse($this->normalizer->supportsNormalization(new InfoNaissance()));

        $this->assertTrue($this->normalizer->supportsNormalization(new EtatCivil()));
        $this->assertTrue($this->normalizer->supportsNormalization(new Ident()));
        $this->assertTrue($this->normalizer->supportsNormalization(new Profession()));
        $this->assertTrue($this->normalizer->supportsNormalization(new SocProcInsee()));
    }

    public function testSupportsDenormalization(): void
    {
        $this->assertFalse($this->normalizer->supportsDenormalization(null, stdClass::class));
        $this->assertFalse($this->normalizer->supportsDenormalization(null, Acteur::class));
        $this->assertFalse($this->normalizer->supportsDenormalization(null, InfoNaissance::class));

        $this->assertTrue($this->normalizer->supportsDenormalization(null, EtatCivil::class));
        $this->assertTrue($this->normalizer->supportsDenormalization(null, Ident::class));
        $this->assertTrue($this->normalizer->supportsDenormalization(null, Profession::class));
        $this->assertTrue($this->normalizer->supportsDenormalization(null, SocProcInsee::class));
    }

    /**
     * @throws ExceptionInterface
     */
    public function testDenormalizeWithEmptyXmlValue(): void
    {
        /** @var EtatCivil $object */
        $object = $this->normalizer->denormalize(
            [
                'dateDeces' => [
                    '@xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                    '@xsi:nil' => 'true',
                ],
            ],
            EtatCivil::class
        );

        $this->assertInstanceOf(EtatCivil::class, $object);

        $this->assertNull($object->getDateDeces());
    }
}
