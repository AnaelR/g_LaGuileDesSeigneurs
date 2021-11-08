<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{

    private $client;
    /**
     * Test index
     */
    public function testIndex(): void
    {
        $this->client->request('GET', '/character/index');
        $this->assertJsonResponse();
    }

    /**
     * Test display
     */
    public function testDisplay()
    {
        $this->client->request('GET', '/character/display/2cfd170cee19ff797265df8844c576c0e38aa630');

        $this->assertJsonResponse();
    }

    /**
     * Assert that a Response is in json
     */
    public function assertJsonResponse()
    {
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
     * Test de redirection
     */
    public function testRedirectIndex()
    {
        $this->client->request('GET', '/character');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Create client
     */
    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * test mauvais identifier
     */
    public function testBadidentifier()
    {
        $this->client->request('GET', '/character/display/badIdentifier');
        $this->assertError404();
    }

    /**
     * test error 404
     */
    public function assertError404()
    {
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test identifiant non existant
     */
    public function testInexistingIdentifier(){
        $this->client->request('GET', '/character/display/error');
        $this->assertError404();
    }

}
