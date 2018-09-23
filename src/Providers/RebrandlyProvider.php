<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 22/09/2018
 * Time: 15:24
 */
namespace App\Providers;

use App\Constants\Constants;
use App\Interfaces\ProviderInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception;

class RebrandlyProvider implements ProviderInterface
{
    private $providerToken;
    private $providerUrl;
    private $providerName = 'rebrandly';
    private $client;
    private $res;

    public function __construct(string $providerToken, string $providerUrl, ClientInterface $client)
    {
        $this->providerToken = $providerToken;
        $this->providerUrl = $providerUrl;
        $this->client = $client;
    }

    /**
     * Used to select Provider during runtime
     *
     * @param string $name
     * @return bool
     */
    public function isRequestedProvider(string $name)
    {
            return $this->providerName === $name;
    }

    /**
     * Gets the url and issues the request to the provider.
     *
     * @param string $longUrl
     * @throws Exception\GuzzleException
     */
    public function doShort(string $longUrl)
    {
        try {
            $this->res = $this->client->request('POST', $this->providerUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'apiKey' => $this->providerToken
                ],
                'json' => [
                    "destination" => $longUrl
                ]
            ]);
        } catch (\Exception $e) {
            /*
             * Guzzle allows us to handle ALL sorts of Exceptions
             * but this error handling created for demo purposes.
             */
            $this->res = [
                Constants::RESPONSE_STATUS => 503,
                Constants::RESPONSE_MESSAGE => Constants::ERROR_SERVICE_UNAVAILABLE
            ];
        }
    }


    /**
     * Handle the response coming from the provider.
     * @return array|mixed
     */
    public function getResponse()
    {
        /**
         * means we have an exception on the request
         * because Guzzle responds with an object
         */
        if (is_array($this->res)) {
            return $this->res;
        }

        /**
         * Handle the response for this provider
         */
        $res = json_decode($this->res->getBody()->getContents(), true);
        $res = [
            Constants::RESPONSE_STATUS => 200,
            Constants::RESPONSE_LONG_URL => $res['destination'],
            Constants::RESPONSE_SHORT_URL => $res['shortUrl'],
        ];
        return $res;
    }
}
