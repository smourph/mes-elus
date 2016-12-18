<?php

namespace App\Service\Utils;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class DataSerializer.
 */
class DataSerializer
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
     * Serialize an unique entity or a set of entities into $format (json by default).
     *
     * @param Entity|Entity[] $entities
     *
     * @return mixed
     */
    public function serialize($entities, string $format = 'json'): string
    {
        if (is_array($entities)) {
            return $this->serializeEntities($entities, $format);
        }

        if (is_object($entities)) {
            return $this->serializeEntities([$entities], $format);
        }

        throw new UnexpectedTypeException($entities, 'array or instance of Entity');
    }

    /**
     * Serialize a set of entities into $format (json by default).
     *
     * @param Entity[] $entities
     *
     * @return mixed
     */
    private function serializeEntities(array $entities, string $format = 'json'): string
    {
        return $this->serializer->serialize($entities, $format);
    }
}
