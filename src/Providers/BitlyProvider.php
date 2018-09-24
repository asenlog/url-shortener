<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 22/09/2018
 * Time: 18:44
 */

namespace App\Providers;

use App\Constants\Constants;
use App\Interfaces\ProviderInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception;
use App\CacheProviders\FileCacheProvider;

class BitlyProvider implements ProviderInterface
{
    private $providerToken;
    private $providerUrl;
    private $client;
    private $cache;

    public function __construct(
        string $providerToken,
        string $providerUrl,
        ClientInterface $client,
        FileCacheProvider $cache
    ) {
        $this->providerToken = $providerToken;
        $this->providerUrl = $providerUrl;
        $this->client = $client;
        $this->cache = $cache;
    }

    /**
     * Gets the url and issues the request to the provider.
     *
     * @param string $longUrl
     * @throws Exception\GuzzleException
     */
    public function doShort(string $longUrl)
    {
        // Check the cache first
        $item = $this->cache->readFromCache('bitly_' . urlencode($longUrl));
        if ($item) {
            return $item;
        }

        try {
            $res = $this->client->request('POST', $this->providerUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->providerToken,
                ],
                'json' => [
                    "long_url" => $longUrl
                ]
            ]);

            /**
             * Prepare the response
             */
            $res = json_decode($res->getBody()->getContents(), true);
            $res = [
                Constants::RESPONSE_STATUS => 200,
                Constants::RESPONSE_LONG_URL => $res['long_url'],
                Constants::RESPONSE_SHORT_URL => $res['link'],
            ];

            /**
             * Save to cache
             */
            $this->cache->writeToCache('bitly_' . urlencode($longUrl), $res);

            return $res;
        } catch (\Exception $e) {
            /**
             * Guzzle allows us to handle ALL sorts of Exceptions
             * but this error handling created for demo purposes.
             */
            return [
                Constants::RESPONSE_STATUS => 503,
                Constants::RESPONSE_MESSAGE => Constants::ERROR_SERVICE_UNAVAILABLE
            ];
        }
    }
}
