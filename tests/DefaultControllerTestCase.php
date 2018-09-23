<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 23/09/2018
 * Time: 00:31
 */

namespace Tests;

use Tests\Functional\BaseTestCase;

class DefaultControllerTestCase extends BaseTestCase
{

    /**
     * Test valid request
     */
    public function testShortenValidRequest()
    {
        $mockedRes = '{"status":200,"longUrl":"http:\/\/www.example.com","shortUrl":"rebrand.ly\/wamrv"}';
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'rebrandly'];
        $response = $this->runApp('POST', '/shorten', $parameters);

        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertContains($mockedRes, (string)$response->getBody());
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

//    /**
//     * Test that the index route with optional name argument returns a rendered greeting
//     */
//    public function testGetHomepageWithGreeting()
//    {
//        $response = $this->runApp('GET', '/name');
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertContains('Hello name!', (string)$response->getBody());
//    }
//
//    /**
//     * Test that the index route won't accept a post request
//     */
//    public function testPostHomepageNotAllowed()
//    {
//        $response = $this->runApp('POST', '/', ['test']);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertContains('Method not allowed', (string)$response->getBody());
//    }

}