<?php

namespace App\Service\Utils;

use App\Entity\AbstractApiEntity;
use Psr\Log\LoggerInterface;

/**
 * Class EntityImporterInterface.
 */
interface EntityImporterInterface
{
    public function setLogger(LoggerInterface $logger): void;

    /**
     * Store entities into their repository.
     */
    public function store(AbstractApiEntity $entities, string $className): void;
}
