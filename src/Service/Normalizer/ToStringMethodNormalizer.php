<?php

namespace App\Service\Normalizer;

use App\Entity\Meselus\LabelizedData;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Object with label normalizer.
 *
 * Class ToStringMethodNormalizer
 */
class ToStringMethodNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) && ($data instanceof LabelizedData);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return class_exists($type) && (LabelizedData::class === $type);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = []): string
    {
        /* @var LabelizedData $object */
        return $object->__toString();
    }
}
