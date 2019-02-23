<?php

namespace App\Service\Normalizer\Datagouv;

use App\Entity\Datagouv\Acteur\EtatCivil;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

/**
 * EtatCivil normalizer.
 *
 * Class EtatCivilNormalizer
 */
class EtatCivilNormalizer extends GetSetMethodNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return \is_object($data) && $data instanceof EtatCivil;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        if (EtatCivil::class !== $type || !class_exists($type)) {
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
        if (!is_string($data['dateDeces'])) {
            $data['dateDeces'] = null;
        }

        return parent::prepareForDenormalization($data);
    }
}
