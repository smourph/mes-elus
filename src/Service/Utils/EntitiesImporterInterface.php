<?php

namespace App\Service\Utils;

use Psr\Log\LoggerInterface;

/**
 * Class EntitiesImporterInterface.
 */
interface EntitiesImporterInterface
{
    public function setLogger(LoggerInterface $logger): void;

    /**
     * Store entities into their repository.
     */
    public function store(object $entities, string $className): void;
}
