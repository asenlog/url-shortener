<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 23/09/2018
 * Time: 00:31
 */

namespace Tests;

class DefaultControllerTest extends BaseTestCase
{

    /**
     * Test valid request
     */
    public function testShortenValidRequest()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'bitly'];
        $response = $this->runApp('POST', '/shorten', $parameters);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('bit.ly', (string)$response->getBody());
    }

    /**
     * Test invalid URI
     * @test
     */
    public function testShortenInvalidURIRequest()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'rebrandly'];
        $response = $this->runApp('POST', '/short', $parameters);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertContains('Not Found', (string)$response->getBody());
    }

    /**
     * Test sending request with missing parameter
     * @test
     */
    public function testShortenWithMissingParameter()
    {
        $parameters = ['provider' => 'bitly'];
        $response = $this->runApp('POST', '/shorten', $parameters);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertContains('Bad Request', (string)$response->getBody());
    }

    /**
     * Test sending request with wrong provider name
     * @test
     */
    public function testShortenWithWrongProviderName()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'bitly1234'];
        $response = $this->runApp('POST', '/shorten', $parameters);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertContains('Bad Request', (string)$response->getBody());
    }

    /**
     * Test sending request with empty provider name
     * @test
     */
    public function testShortenWithEmptyProviderName()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => ''];
        $response = $this->runApp('POST', '/shorten', $parameters);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('bit.ly', (string)$response->getBody());
    }

    /**
     * Test sending request with extra parameter
     * @test
     */
    public function testShortenWithExtraParameter()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'bitly', 'test' => 'test'];
        $response = $this->runApp('POST', '/shorten', $parameters);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertContains('Bad Request', (string)$response->getBody());
    }

    /**
     * Test sending request with not allowed method parameter
     * @test
     */
    public function testShortenWithDisallowedMethod()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'bitly'];
        $response = $this->runApp('GET', '/shorten', $parameters);

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string)$response->getBody());
    }

}