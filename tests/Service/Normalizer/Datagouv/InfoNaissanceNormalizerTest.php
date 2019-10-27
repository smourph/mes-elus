<?php

namespace App\Tests\Service\Normalizer\Datagouv;

use App\Entity\Datagouv\Acteur\InfoNaissance;
use App\Service\Normalizer\AbstractApiEntityNormalizer;
use App\Service\Normalizer\Datagouv\InfoNaissanceNormalizer;
use DateTime;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class InfoNaissanceNormalizerTest.
 */
class InfoNaissanceNormalizerTest extends TestCase
{
    /**
     * @var InfoNaissanceNormalizer
     */
    private $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new InfoNaissanceNormalizer();
    }

    public function testInterface(): void
    {
        $this->assertInstanceOf(AbstractApiEntityNormalizer::class, $this->normalizer);
    }

    public function testSupportsNormalization(): void
    {
        $this->assertFalse($this->normalizer->supportsNormalization(new stdClass()));
        $this->assertTrue($this->normalizer->supportsNormalization(new InfoNaissance()));
    }

    public function testSupportsDenormalization(): void
    {
        $this->assertFalse($this->normalizer->supportsDenormalization(null, stdClass::class));
        $this->assertTrue($this->normalizer->supportsDenormalization(null, InfoNaissance::class));
    }

    /**
     * @throws ExceptionInterface
     */
    public function testDenormalize(): void
    {
        $objectNormalizer = new ObjectNormalizer(
            null,
            null,
            null,
            new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()])
        );
        $serializer = new Serializer([new DateTimeNormalizer(), $objectNormalizer, $this->normalizer]);

        /** @var InfoNaissance $object */
        $object = $serializer->denormalize(
            [
                'dateNais' => '2000-01-01',
                'villeNais' => 'Libourne',
                'depNais' => 'Gironde',
                'paysNais' => 'France',
            ],
            InfoNaissance::class
        );

        $this->assertInstanceOf(InfoNaissance::class, $object);

        $this->assertEquals(new DateTime('2000-01-01'), $object->getDateNais());
        $this->assertEquals('Libourne', $object->getVilleNais());
        $this->assertEquals('Gironde', $object->getDepNais());
        $this->assertEquals('France', $object->getPaysNais());
    }

    /**
     * @throws ExceptionInterface
     */
    public function testDenormalizeWithEmptyDateNais(): void
    {
        /** @var InfoNaissance $object */
        $object = $this->normalizer->denormalize(
            [
                'dateNais' => null,
                'villeNais' => 'Libourne',
                'depNais' => 'Gironde',
                'paysNais' => 'France',
            ],
            InfoNaissance::class
        );

        $this->assertInstanceOf(InfoNaissance::class, $object);

        $this->assertNull($object->getDateNais());
    }
}
