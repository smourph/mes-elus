<?php

namespace App\Tests\Controller;

use App\Test\RestWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

/**
 * Class ActeurControllerTest.
 */
class ActeurControllerTest extends RestWebTestCase
{
    /**
     * @var KernelBrowser
     */
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testList(): void
    {
        $this->client->request('GET', 'acteurs/');

        $response = $this->client->getResponse();
        $this->assertJsonResponse($response);
    }

    public function testShow(): void
    {
        $this->client->request('GET', 'acteur/uid1');

        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }
}
