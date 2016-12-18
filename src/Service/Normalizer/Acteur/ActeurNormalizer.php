<?php

namespace App\Service\Normalizer\Acteur;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Entity\Datagouv\Acteur\EtatCivil;
use App\Entity\Datagouv\Acteur\Profession;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Acteur normalizer.
 *
 * Class ActeurNormalizer
 */
class ActeurNormalizer extends ObjectNormalizer
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
        return class_exists($type) && Acteur::class === $type;
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareForDenormalization($data): array
    {
        // Reorganize data
        $preparedData = [
            'uid' => $data['uid']['#text'],
            'etatCivil' => $this->serializer->deserialize(
                json_encode($data['etatCivil']),
                EtatCivil::class,
                'json'
            ),
            'profession' => $this->serializer->deserialize(
                json_encode($data['profession']),
                Profession::class,
                'json'
            ),
        ];

        return parent::prepareForDenormalization($preparedData);
    }
}
