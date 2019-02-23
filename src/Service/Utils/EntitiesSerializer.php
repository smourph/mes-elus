<?php

namespace App\Service\Utils;

use App\Entity\Datagouv\ApiEntity;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class EntitiesSerializer.
 */
class EntitiesSerializer implements EntitiesSerializerInterface
{
    /** @var EntitiesSerializerInterface */
    private $serializer;

    /** @var LoggerInterface */
    private $logger;

    /**
     * {@inheritdoc}
     */
    public function __construct(SerializerInterface $serializer, LoggerInterface $logger)
    {
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * Extract entities from a json file.
     *
     * @throws \JsonException
     */
    public function extractFromJson(string $fileContents, string $className): object
    {
        $this->logger->debug('Extract "'.$className.'" entities',
            ['class' => __CLASS__, 'method' => __FUNCTION__]
        );

        // Get file contents
        /** @var ApiEntity[] $entities */
        $entities = $this->serializer->deserialize(
            $fileContents,
            $className,
            'json',
            ['entityName' => $className]
        );

        if (empty($entities)) {
            throw new \JsonException('Invalid or empty JSON file');
        }

        return $entities;
    }
}
