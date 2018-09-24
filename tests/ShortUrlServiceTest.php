<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 23/09/2018
 * Time: 20:06
 */

namespace Tests;

use App\Providers\BitlyProvider;
use App\Providers\RebrandlyProvider;
use App\Services\ShortUrlService;

class ShortUrlServiceTest extends BaseTestCase
{
    /**
     * Check that the ShortService sets the appropriate provider instance
     */

    /**
     * @see \App\Services\ShortUrlService::setProvider()
     * @test
     */
    public function rebrandlyProviderIsUsed()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'rebrandly'];
        $this->runApp('POST', '/shorten', $parameters);

        $this->assertInstanceOf(RebrandlyProvider::class, $this->app->getContainer()->get(ShortUrlService::class));
    }

    /**
     * @see \App\Services\ShortUrlService::setProvider()
     * @test
     */
    public function bitlyProviderIsUsed()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'bitly'];
        $this->runApp('POST', '/shorten', $parameters);

        $this->assertInstanceOf(BitlyProvider::class, $this->app->getContainer()->get(ShortUrlService::class));
    }

    /**
     * @see \App\Services\ShortUrlService::setProvider()
     * @test
     */
    public function defaultProviderIsUsed()
    {
        $parameters = ['url' => 'http://www.example.com'];
        $this->runApp('POST', '/shorten', $parameters);

        $this->assertInstanceOf(BitlyProvider::class, $this->app->getContainer()->get(ShortUrlService::class));
    }
}
