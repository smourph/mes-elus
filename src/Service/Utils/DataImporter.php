<?php

namespace App\Service\Utils;

use App\Entity\Datagouv\Acteur\Acteur;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class DataImporter.
 */
class DataImporter
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * DataImporter constructor.
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Extract entities from a json file.
     *
     * @return Entity[]
     */
    public function extractEntitiesFromJsonFile(string $fileName, string $className): array
    {
        $data = $this->decodeJsonFileToArray($fileName);

        // Get the specific child in json for each entity
        if (Acteur::class === $className) {
            $data = $data['export']['acteurs']['acteur'];
        }

        return $this->deserializeEntities($data, $className);
    }

    /**
     * Extract an array of data from a json file.
     */
    private function decodeJsonFileToArray(string $fileName): array
    {
        // Decode json data from file
        $file = new File($fileName);
        $fileContent = file_get_contents($file->getPathname());

        return json_decode($fileContent, true);
    }

    /**
     * Extract entities from an array of data.
     *
     * @return Entity[]
     */
    private function deserializeEntities(array $data, string $className): array
    {
        // Serialize array data to entities
        $entities = [];
        foreach ($data as $element) {
            $entities[] = $this->serializer->deserialize(json_encode($element), $className, 'json');
        }

        return $entities;
    }
}
