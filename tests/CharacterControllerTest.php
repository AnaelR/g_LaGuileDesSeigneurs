<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    /**
     * Test index
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character/index');
        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Test display
     */
    public function testDisplay()
    {
        $client = static::createClient();
        $client->request('GET', '/character/display/2cfd170cee19ff797265df8844c576c0e38aa630');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Assert that a Response is in json
     */
    public function assertJsonResponse($response)
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    public function testRedirectIndex(){
        $client = static::createClient();
        $client->request('GET', '/character');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
