<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 22/09/2018
 * Time: 19:19
 */

namespace App\Services;

use App\Constants\Constants;
use App\Interfaces\ProviderInterface;
use App\Providers\RebrandlyProvider;
use Pimple\Container;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ShortUrlService
{
    private $provider;
    private $container;
    private $request;

    /**
     * ShortUrlService constructor.
     *
     * @param ContainerInterface $container
     * @param Request $request
     */
    public function __construct(ContainerInterface $container, Request $request)
    {
        $this->container = $container;
        $this->request = $request;
    }

    /**
     * The original idea here was to use the Strategy Pattern with the Service
     * registering the provider in the container by implementing the Pimple/ServiceProviderInterface
     *
     * Due to lack of time and a bit of poor documentation on Pimple and Slim, i have registered
     * the providers in the container using the setProvider() method for switching at runtime.
     */

    /**
     * Set services on the given container.
     *
     * @return mixed
     */
    public function setProvider()
    {
        $provider = $this->request->getParsedBodyParam('provider', Constants::PARAMETER_PROVIDER_BITLY);
        return $this->provider = $this->container->get($provider);
    }
}
