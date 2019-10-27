<?php

namespace App\Service\Normalizer\Datagouv;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Service\Normalizer\AbstractApiEntityNormalizer;
use function is_object;

/**
 * Acteur normalizer.
 *
 * Class ActeurNormalizer.
 */
class ActeurNormalizer extends AbstractApiEntityNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) && $data instanceof Acteur;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        if (Acteur::class !== $type) {
            return false;
        }

        // Verify that the format of data is mapped to the json file
        return isset($data['acteur']['uid']['#text']);
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareForDenormalization($data): array
    {
        // Reorganize array
        $data = $data['acteur'];
        $data['uid'] = $data['uid']['#text'];

        return parent::prepareForDenormalization($data);
    }

    /**
     * {@inheritdoc}
     */
    protected function extractAttributes($object, $format = null, array $context = [])
    {
        $attributes = parent::extractAttributes($object, $format, $context);

        // Hide "id" attribute (AbstractApiEntity) from normalization
        if (false !== ($key = array_search('id', $attributes, true))) {
            unset($attributes[$key]);
        }

        return $attributes;
    }
}
