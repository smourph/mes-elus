<?php

namespace App\Tests\Controller;

use App\Test\RestWebTestCase;

/**
 * Class ActeurControllerTest.
 */
class ActeurControllerTest extends RestWebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();

        $client->request('GET', 'acteurs/');

        $response = $client->getResponse();
        $this->assertJsonResponse($response);
    }

    public function testShow(): void
    {
        $client = static::createClient();

        $client->request('GET', 'acteur/uid1');

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }
}
