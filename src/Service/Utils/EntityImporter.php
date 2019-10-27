<?php

namespace App\Service\Utils;

use App\Entity\AbstractApiEntity;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * Class EntityImporter.
 */
class EntityImporter implements EntityImporterInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var LoggerInterface */
    private $logger;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
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
     * Store entity in its repository.
     *
     * @throws ConnectionException
     */
    public function store(AbstractApiEntity $entity, string $className): void
    {
        if (!is_a($entity, $className)) {
            throw new InvalidArgumentException('Entity must be instance of "'.$className.'"');
        }

        try {
            // Turning off doctrine default logs queries for saving memory
            $this->em->getConnection()->getConfiguration()->setSQLLogger();

            // Begin an SQL transaction
            $this->em->getConnection()->beginTransaction();
            $this->logger->debug('Begin the SQL transaction', ['class' => __CLASS__, 'method' => __FUNCTION__]);

            $this->logger->debug('Store "'.$className.'"', ['class' => __CLASS__, 'method' => __FUNCTION__]);

            /** @var AbstractApiEntity $previousEntity */
            $previousEntity = $this->em->getRepository($className)->find($entity->getId());

            if (!$previousEntity) {
                // Create a new Entity
                $this->em->persist($entity);
            } else {
                $previousEntity->update($entity);
            }

            $this->em->flush();
            $this->em->clear();

            // Commit to end the SQL transaction
            $this->em->getConnection()->commit();
            $this->logger->debug(
                'Commit and close the SQL transaction',
                ['class' => __CLASS__, 'method' => __FUNCTION__]
            );
        } catch (Exception $e) {
            // Rollback to previous data then close transaction
            $this->em->getConnection()->rollBack();
            $this->em->close();

            $this->logger->alert(
                'Roll back and close the SQL transaction',
                ['class' => __CLASS__, 'method' => __FUNCTION__]
            );

            throw $e;
        }
    }
}
