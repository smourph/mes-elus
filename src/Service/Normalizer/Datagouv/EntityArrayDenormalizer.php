<?php

namespace App\Service\Normalizer\Datagouv;

use App\Entity\Datagouv\Acteur\Acteur;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Array of Entity denormalizer.
 *
 * Class EntityArrayDenormalizer
 */
class EntityArrayDenormalizer implements ContextAwareDenormalizerInterface, SerializerAwareInterface
{
    protected const ENTITIES = [
        Acteur::class,
    ];
    /**
     * @var SerializerInterface|DenormalizerInterface
     */
    private $serializer;

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        // Prevents infinite call of this denormalizer
        $context += ['ActeurArrayAlreadyProcessed' => true];

        // Get the specific child from data
        switch ($context['entityName']) {
            case Acteur::class:
                $data = $data['acteur'];
                break;
        }

        return $this->serializer->denormalize($data, Acteur::class, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        // Prevents infinite call of this denormalizer
        if (isset($context['ActeurArrayAlreadyProcessed']) && $context['ActeurArrayAlreadyProcessed']) {
            return false;
        }

        // This denormalizer must be use with a correct context 'entityName'
        if (!isset($context['entityName']) || !in_array($context['entityName'], self::ENTITIES, true)) {
            return false;
        }

        // @see \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer
        return '[]' === substr($type, -2)
            && $this->serializer->supportsDenormalization($data, substr($type, 0, -2), $format, $context);
    }

    /**
     * Sets the owning Serializer object.
     */
    public function setSerializer(SerializerInterface $serializer): void
    {
        if (!$serializer instanceof DenormalizerInterface) {
            throw new InvalidArgumentException('Expected a serializer that also implements DenormalizerInterface.');
        }

        $this->serializer = $serializer;
    }
}
