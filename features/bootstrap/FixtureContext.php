<?php

use Behat\Behat\Context\Context;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use Fidry\AliceDataFixtures\LoaderInterface;

class FixtureContext implements Context
{
    /** @var LoaderInterface */
    private $loader;

    /** @var string */
    private $fixturesBasePath;

    /** @var array */
    private $fixtures;

    public function __construct(Registry $doctrine, LoaderInterface $loader, string $fixturesBasePath)
    {
        /** @var Connection[] $connections */
        $connections = $doctrine->getConnections();
        foreach ($connections as $connection) {
            if ('pdo_sqlite' !== $connection->getDriver()->getName()) {
                throw new RuntimeException('Wrong connection driver: '.$connection->getDriver()->getName());
            }
        }

        $this->loader = $loader;
        $this->fixturesBasePath = $fixturesBasePath;

        /** @var ObjectManager[] $managers */
        $managers = $doctrine->getManagers();

        foreach ($managers as $manager) {
            if ($manager instanceof EntityManagerInterface) {
                $schemaTool = new SchemaTool($manager);
                $schemaTool->dropDatabase();
                try {
                    $schemaTool->createSchema($manager->getMetadataFactory()->getAllMetadata());
                } catch (ToolsException $e) {
                }
            }
        }
    }

    /**
     * @Given the fixtures file :fixturesFile is loaded
     */
    public function theFixturesFileIsLoaded(string $fixturesFile): void
    {
        $this->fixtures = $this->loader->load([$this->fixturesBasePath.$fixturesFile]);
    }
}
