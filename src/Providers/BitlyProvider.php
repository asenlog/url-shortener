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
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

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
        FilesystemAdapter $cache
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
        if ($this->cache->hasItem('bitly_' . urlencode($longUrl))) {
            $res = $this->cache->getItem('bitly_' . urlencode($longUrl));
            return $res->get();
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
            $bitlyCache = $this->cache->getItem('bitly_' . urlencode($longUrl));
            if (!$bitlyCache->isHit()) {
                $bitlyCache->set($res);
                $this->cache->save($bitlyCache);
            }

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
