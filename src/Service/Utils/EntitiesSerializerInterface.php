<?php

namespace App\Service\Utils;

use Psr\Log\LoggerInterface;

/**
 * Class EntitiesSerializerInterface.
 */
interface EntitiesSerializerInterface
{
    public function setLogger(LoggerInterface $logger): void;

    /**
     * Extract entities from a json file.
     */
    public function extractFromJson(string $fileContents, string $className): object;
}
