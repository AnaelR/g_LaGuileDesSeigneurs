<?php

namespace App\Tests\Controller;

use App\Entity\Character;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class CharacterControllerTest extends WebTestCase
{

    private $client;
    private $content;
    private static $identifier;
    /**
     * Test index
     */
    public function testIndex(): void
    {
        $this->client->request('GET', '/character/index');
        $this->assertJsonResponse();
    }

    /**
     * Test create
     */
    public function testCreate()
    {
        $this->client->request(
            'POST',
            '/character/create',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"kind":"Dame","name":"Eldalótë","surname":"Fleur elfique","caste":"Elfe","knowledge":"Arts","intelligence":120,"life":12,"image":"/images/eldalote.jpg"}'
        );
        // dd($this->client->getResponse());
        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    /**
     * Test display
     */
    public function testDisplay()
    {
        $this->client->request('GET', '/character/display/' . self::$identifier);
        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    public function testModify()
    {
        $this->client->request(
            'PUT',
            '/character/modify/' . self::$identifier,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"kind":"Seigneur","name":"Gorthol"}'
        );

        $this->assertJsonResponse();
        $this->assertIdentifier();

        $this->client->request(
            'PUT',
            '/character/modify/' . self::$identifier,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"kind":"Dame","name":"Eldalótë","surname":"Fleur elfique","caste":"Elfe","knowledge":"Arts","intelligence":120,"life":12,"image":"/images/eldalote.jpg"}'
        );

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    public function testDelete()
    {
        $this->client->request('DELETE', '/character/delete/' . self::$identifier);
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
    public function testInexistingIdentifier()
    {
        $this->client->request('GET', '/character/display/error');
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

    /**
     * Show characters by level of intelligence in API
     */
    public function testGetLevelOfIntelligence()
    {
        $this->client->request('GET', '/character/intelligence/100');
        $this->assertJsonResponse();
    }

    /**
     * Show characters by level of intelligence in HTML
     */
    public function testGetLevelOfIntelligenceHtml()
    {
        $this->client->request('GET', '/character/html/intelligence/100');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Show characters by level of intelligence in HTML
     */
    public function testGetLevelOfIntelligenceApiHtml()
    {
        $this->client->request('GET', '/character/api-html/intelligence/100');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test images
     */

    public function testImages()
    {
        //Tests without kind
        $this->client->request('GET', '/character/images/3');
        $this->assertJsonResponse();

        //Tests with kind
        $this->client->request('GET', '/character/images/dames/3');
        $this->assertJsonResponse();

        $this->client->request('GET', '/character/images/ennemis/3');
        $this->assertJsonResponse();

        $this->client->request('GET', '/character/images/ennemies/3');
        $this->assertJsonResponse();

        $this->client->request('GET', '/character/images/seigneurs/3');
        $this->assertJsonResponse();
    }
}
