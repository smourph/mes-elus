<?php

namespace App\Service\Normalizer\Acteur;

use App\Entity\Datagouv\Acteur\Profession;
use App\Entity\Datagouv\Acteur\SocProcINSEE;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Profession normalizer.
 *
 * Class ProfessionNormalizer
 */
class ProfessionNormalizer extends ObjectNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) && $data instanceof Profession;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return class_exists($type) && Profession::class === $type;
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareForDenormalization($data): array
    {
        // Reorganize data
        $preparedData = [
            'libelleCourant' => $data['libelleCourant'],
            'socProcINSEE' => $this->serializer->deserialize(
                json_encode($data['socProcINSEE']),
                SocProcINSEE::class,
                'json'
            ),
        ];

        return parent::prepareForDenormalization($preparedData);
    }
}
