<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 22/09/2018
 * Time: 19:19
 */

namespace App\Services;

use App\Constants\Constants;

class ShortUrlService
{
    private $providers;

    /**
     * ShortUrlService constructor.
     *
     * @param array $providers (Injected from the dependencies)
     */
    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    /**
     * The original idea here was to use the Strategy Pattern with each of the providers
     * registering themselves in the container by implementing the Pimple/ServiceProviderInterface
     * and the loop over here deciding which provider to use during runtime.
     *
     * Due to lack of time and a bit of poor documentation on Pimple and Slim, i have registered
     * the providers in the container in the dependencies.php and injecting them here to get them.
     *
     * @param $parameters
     * @return mixed
     */
    public function shortUrl($parameters)
    {
        foreach ($this->providers as $provider) {
            if ($provider->isRequestedProvider($parameters[Constants::PARAMETER_PROVIDER])) {
                $provider->doShort($parameters[Constants::PARAMETER_URL]);
                return $provider->getResponse();
            }
        }
    }

}
