<?php

namespace App\Service\Normalizer\Datagouv;

use App\Entity\Datagouv\Acteur\Acteur;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

/**
 * Acteur normalizer.
 *
 * Class ActeurNormalizer
 */
class ActeurNormalizer extends GetSetMethodNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return \is_object($data) && $data instanceof Acteur;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        if (Acteur::class !== $type || !class_exists($type)) {
            return false;
        }

        // Verify that the format of data is mapped to the json file
        return isset($data['uid']['#text']);
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareForDenormalization($data): array
    {
        // Reorganize array
        $data['uid'] = $data['uid']['#text'];

        return parent::prepareForDenormalization($data);
    }
}
