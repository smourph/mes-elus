<?php

namespace App\Tests\Service\Normalizer\Datagouv;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Service\Normalizer\Datagouv\ActeurNormalizer;
use App\Service\Normalizer\Datagouv\EntityArrayDenormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class EntityArrayDenormalizerTest.
 */
class EntityArrayDenormalizerTest extends TestCase
{
    /**s
     * @var EntityArrayDenormalizer
     */
    private $normalizer;

    protected function setUp()
    {
        $this->normalizer = new EntityArrayDenormalizer();
        $this->normalizer->setSerializer($this->createMockedSerializer());
    }

    public function testSupportsDenormalization(): void
    {
        $this->assertFalse($this->normalizer->supportsDenormalization(null, \stdClass::class));

        // Test Acteur support
        $this->assertFalse($this->normalizer->supportsDenormalization(null, Acteur::class.'[]'));
        $this->assertTrue(
            $this->normalizer->supportsDenormalization(
                null,
                Acteur::class.'[]',
                null,
                ['entityName' => Acteur::class]
            )
        );
    }

    public function testActeurDenormalize(): void
    {
        /** @var Acteur[] $acteurs */
        $acteurs = $this->normalizer->denormalize(
            [
                'acteur' => [
                    ['foo1' => 'foo1'],
                    ['foo2' => 'foo2'],
                ],
            ],
            Acteur::class.'[]',
            null,
            ['entityName' => Acteur::class]
        );

        $this->assertCount(2, $acteurs);

        $this->assertInstanceOf(Acteur::class, $acteurs[0]);
        $this->assertEquals('uid1', $acteurs[0]->getUid());

        $this->assertInstanceOf(Acteur::class, $acteurs[1]);
        $this->assertEquals('uid2', $acteurs[1]->getUid());
    }

    private function createMockedSerializer(): SerializerInterface
    {
        $acteur1 = (new Acteur())
            ->setUid('uid1');
        $acteur2 = (new Acteur())
            ->setUid('uid2');

        $acteurNormalizer = $this->createMock(ActeurNormalizer::class);
        $acteurNormalizer
            ->method('denormalize')
            ->withConsecutive(
                [['foo1' => 'foo1'], $this->anything()],
                [['foo2' => 'foo2'], $this->anything()]
            )
            ->willReturnOnConsecutiveCalls($acteur1, $acteur2);
        $acteurNormalizer
            ->method('supportsDenormalization')
            ->with($this->anything(), Acteur::class, $this->anything(), $this->anything())
            ->willReturn(true);

        return new Serializer([new ArrayDenormalizer(), $acteurNormalizer]);
    }
}
