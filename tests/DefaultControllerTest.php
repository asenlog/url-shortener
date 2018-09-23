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
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'rebrandly'];
        $response = $this->runApp('POST', '/shorten', $parameters);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test invalid URI
     */
    public function testShortenInvalidURIRequest()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'rebrandly'];
        $response = $this->runApp('POST', '/short', $parameters);

        $result = json_decode($response->getBody(), true);
        $this->assertEquals(404, $response->getStatusCode());
        //$this->assertSame('Route Not Found..', $result['message']);
    }

    /**
     * Test sending request with missing parameter
     */
    public function testShortenWithMissingParameter()
    {
        $parameters = ['provider' => 'bitly'];
        $response = $this->runApp('POST', '/shorten', $parameters);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertContains('Invalid Parameter', (string)$response->getBody());
    }

    /**
     * Test sending request with extra parameter
     */
    public function testShortenWithExtraParameter()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'bitly', 'test' => 'test'];
        $response = $this->runApp('POST', '/shorten', $parameters);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertContains('Invalid Parameter', (string)$response->getBody());
    }

    /**
     * Test sending request with not allowed method parameter
     */
    public function testShortenWithDisallowedMethod()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'bitly'];
        $response = $this->runApp('GET', '/shorten', $parameters);

        $this->assertEquals(405, $response->getStatusCode());
    }

}