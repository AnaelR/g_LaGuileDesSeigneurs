<?php

namespace App\Tests\Controller;

use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlayerControllerTest extends WebTestCase
{

    private $client;
    private $content;
    private static $identifier;
    /**
     * Test index
     */
    public function testIndex(): void
    {
        $this->client->request('GET', '/player/index');
        $this->assertJsonResponse();
    }

    /**
     * Test create
     */
    public function testCreate()
    {
        $this->client->request('POST', '/player/create');
        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    /**
     * Test display
     */
    public function testDisplay()
    {
        $this->client->request('GET', '/player/display/' . self::$identifier);
        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    public function testModify()
    {
        $this->client->request('PUT', '/player/modify/' . self::$identifier);
        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    public function testDelete() 
    {
        $this->client->request('DELETE', '/player/delete/' . self::$identifier);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Assert that a Response is in json
     */
    public function assertJsonResponse()
    {
        $response = $this->client->getResponse();
        $this->content = json_decode($response->getContent(), true, 50);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
     * Test de redirection
     */
    public function testRedirectIndex()
    {
        $this->client->request('GET', '/player');

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
        $this->client->request('GET', '/player/display/badIdentifier');
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
    public function testInexistingIdentifier()
    {
        $this->client->request('GET', '/player/display/error');
        $this->assertError404();
    }

    /**
     * Asserts that 'identifier' is present in the Response
     */
    public function assertIdentifier()
    {
        $this->assertArrayHasKey('identifier', $this->content);
    }

    /**
     * Define identifier
     */
    public function defineIdentifier()
    {
        self::$identifier = $this->content['identifier'];
    }
}
