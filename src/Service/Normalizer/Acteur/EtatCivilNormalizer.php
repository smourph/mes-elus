<?php

namespace App\Service\Normalizer\Acteur;

use App\Entity\Datagouv\Acteur\EtatCivil;
use App\Entity\Datagouv\Acteur\Ident;
use App\Entity\Datagouv\Acteur\InfoNaissance;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * EtatCivil normalizer.
 *
 * Class EtatCivilNormalizer
 */
class EtatCivilNormalizer extends ObjectNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) && $data instanceof EtatCivil;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return class_exists($type) && EtatCivil::class === $type;
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareForDenormalization($data): array
    {
        // Reorganize data
        $preparedData = [
            'ident' => $this->serializer->deserialize(
                json_encode($data['ident']),
                Ident::class,
                'json'
            ),
            'infoNaissance' => $this->serializer->deserialize(
                json_encode($data['infoNaissance']),
                InfoNaissance::class,
                'json'
            ),
            'dateDeces' => $data['dateDeces'],
        ];

        return parent::prepareForDenormalization($preparedData);
    }
}
