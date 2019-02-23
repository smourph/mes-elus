<?php

namespace App\Service\Normalizer\Datagouv;

use App\Entity\Datagouv\Acteur\InfoNaissance;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

/**
 * InfoNaissance normalizer.
 *
 * Class InfoNaissanceNormalizer
 */
class InfoNaissanceNormalizer extends GetSetMethodNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return \is_object($data) && $data instanceof InfoNaissance;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        if (InfoNaissance::class !== $type || !class_exists($type)) {
            return false;
        }

        // Verify that the format of data is mapped to the json file
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareForDenormalization($data): array
    {
        // clean wrong data type
        if (!is_string($data['depNais'])) {
            $data['depNais'] = null;
        }
        if (!is_string($data['dateNais'])) {
            $data['dateNais'] = null;
        }

        return parent::prepareForDenormalization($data);
    }
}
