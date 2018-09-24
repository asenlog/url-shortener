<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 23/09/2018
 * Time: 20:05
 */

namespace Tests;

use App\Controllers\DefaultController;
use App\Providers\BitlyProvider;
use App\Providers\RebrandlyProvider;
use App\Services\ValidatorService;
use GuzzleHttp\ClientInterface;
use Monolog\Logger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class DependenciesTest extends BaseTestCase
{
    /**
     * Check that the dependencies have been loaded in the container
     */

    /**
     * @see Logger
     * @test
     */
    public function loggerAddedToContainer()
    {
        $this->assertInstanceOf(Logger::class, $this->app->getContainer()->get('logger'));
    }

    /**
     * @see Symfony\Component\Cache\Simple\FilesystemCache;
     * @test
     */
    public function symfonyCacheAddedToContainer()
    {
        $this->assertInstanceOf(FilesystemAdapter::class, $this->app->getContainer()->get('cache'));
    }

    /**
     * @see \GuzzleHttp\ClientInterface;
     * @test
     */
    public function guzzleClientAddedToContainer()
    {
        $this->assertInstanceOf(ClientInterface::class, $this->app->getContainer()->get('client'));
    }

    /**
     * @see \App\Providers\RebrandlyProvider
     * @test
     */
    public function rebrandlyProviderAddedToContainer()
    {
        $this->assertInstanceOf(RebrandlyProvider::class, $this->app->getContainer()->get('rebrandly'));
    }

    /**
     * @see \App\Providers\BitlyProvider
     * @test
     */
    public function bitlyProviderAddedToContainer()
    {
        $this->assertInstanceOf(BitlyProvider::class, $this->app->getContainer()->get('bitly'));
    }

    /**
     * @see \App\Services\ValidatorService
     * @test
     */
    public function validatorServiceAddedToContainer()
    {
        $this->assertInstanceOf(ValidatorService::class, $this->app->getContainer()->get(ValidatorService::class));
    }

    /**
     * @see \App\Controllers\DefaultController
     * @test
     */
    public function controllerAddedToContainer()
    {
        $this->assertInstanceOf(DefaultController::class, $this->app->getContainer()->get(DefaultController::class));
    }
}
