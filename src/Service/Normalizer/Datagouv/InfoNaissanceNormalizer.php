<?php

namespace App\Service\Normalizer\Datagouv;

use App\Entity\Datagouv\Acteur\InfoNaissance;
use App\Service\Normalizer\AbstractApiEntityNormalizer;
use function is_object;

/**
 * InfoNaissance normalizer.
 *
 * Class InfoNaissanceNormalizer.
 */
class InfoNaissanceNormalizer extends AbstractApiEntityNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) && $data instanceof InfoNaissance;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return InfoNaissance::class === $type;
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareForDenormalization($data): array
    {
        // Clean wrong data type
        if (!is_string($data['dateNais'])) {
            $data['dateNais'] = null;
        }

        return parent::prepareForDenormalization($data);
    }
}
