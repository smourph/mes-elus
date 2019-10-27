<?php

namespace App\Service\Normalizer;

use App\Entity\AbstractApiEntity;
use App\Entity\Datagouv\Acteur\Acteur;
use App\Entity\Datagouv\Acteur\InfoNaissance;
use function is_object;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

/**
 * AbstractApiEntityNormalizer normalizer.
 *
 * Class AbstractApiEntityNormalizer.
 */
class AbstractApiEntityNormalizer extends GetSetMethodNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        if (!is_object($data)) {
            return false;
        }

        // Bypass this normalizer for Entity with specific denormalization
        if ($data instanceof Acteur || $data instanceof InfoNaissance) {
            return false;
        }

        return $data instanceof AbstractApiEntity || is_subclass_of($data, AbstractApiEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        // Bypass this normalizer for Entity with specific denormalization
        if (Acteur::class === $type || InfoNaissance::class === $type) {
            return false;
        }

        return is_subclass_of($type, AbstractApiEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareForDenormalization($data): array
    {
        // Clean empty data
        foreach ($data as $key => $value) {
            if (is_array($value) && isset($value['@xsi:nil'])) {
                $data[$key] = null;
            }
        }

        return parent::prepareForDenormalization($data);
    }
}
