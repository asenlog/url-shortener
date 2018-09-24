<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 22/09/2018
 * Time: 19:19
 */

namespace App\Services;

use App\Constants\Constants;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;

class ShortUrlService
{
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
     * The original idea here was to use the Strategy Pattern with the ShortUrlService
     * registering the provider in the container by implementing the Pimple/ServiceProviderInterface
     *
     * Due poor documentation on Pimple and Slim and lack of time, i have registered
     * the providers in the container using the setProvider() method for switching provider at runtime.
     */

    /**
     * Set service on the container.
     *
     * @return mixed
     */
    public function setProvider()
    {
        // if provider comes empty set the default one
        $provider = $this->request->getParsedBodyParam(Constants::PARAMETER_PROVIDER);
        if (empty($provider)) {
            $provider = Constants::PARAMETER_PROVIDER_DEFAULT;
        }
        return $this->container->get($provider);
    }
}
