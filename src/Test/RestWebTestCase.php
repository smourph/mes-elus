<?php

namespace App\Test;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use PHPUnit\Framework\MockObject\MockBuilder;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class RestWebTestCase.
 */
abstract class RestWebTestCase extends WebTestCase
{
    protected function loadService(string $service): object
    {
        return self::$container->get($service);
    }

    /**
     * @return SerializerInterface
     */
    protected function loadSerializer(): object
    {
        return $this->loadService('serializer');
    }

    /**
     * @param string $name
     */
    protected function loadManager(string $name = null, string $registryName = 'doctrine'): ObjectManager
    {
        /** @var ManagerRegistry $registry */
        $registry = $this->loadService($registryName);

        return $registry->getManager($name);
    }

    /**
     * @param string $managerName
     */
    protected function loadRepository(
        string $name,
        string $managerName = null,
        string $registryName = 'doctrine'
    ): ObjectRepository {
        return $this->loadManager($managerName, $registryName)->getRepository($name);
    }

    /**
     * Creates a mock object of a service identified by its id.
     *
     * @param string $id
     */
    protected function getServiceMockBuilder($id): MockBuilder
    {
        $service = self::$container->get($id);
        $class = get_class($service);

        return $this->getMockBuilder($class)->disableOriginalConstructor();
    }

    protected function assertJsonResponse(Response $response, int $statusCode = 200): void
    {
        $this->assertEquals($statusCode, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
        $this->assertJson($response->getContent());
    }

    /**
     * @return mixed
     */
    protected function getValidJsonResponse(Response $response)
    {
        $decode = json_decode($response->getContent());
        $this->assertTrue(null !== $decode && false !== $decode, $response->getContent());

        return $decode;
    }

    /**
     * @return mixed
     */
    protected function getValidDeserializedJsonResponse(Response $response, string $type, array $context = [])
    {
        /** @var SerializerInterface $serializer */
        $serializer = $this->loadService('serializer');
        $decode = $serializer->deserialize($response->getContent(), $type, 'json', $context);

        $this->assertTrue(null !== $decode && false !== $decode, $response->getContent());

        return $decode;
    }

    /**
     * @param $method
     * @param $url
     */
    protected function jsonRequest(string $method, string $url, array $data = []): Crawler
    {
        $json = empty($data) ? null : json_encode($data);

        return self::createClient()->request(
            $method,
            $url,
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $json
        );
    }
}
