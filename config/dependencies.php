<?php
// DIC configuration
use App\CacheProviders\FileCacheProvider;
use App\Controllers\DefaultController;
use App\Providers\BitlyProvider;
use App\Providers\RebrandlyProvider;
use App\Services\CacheService;
use App\Services\ShortUrlService;
use App\Services\ValidatorService;
use GuzzleHttp\Client;

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

/*
 * Cache Service
 */
$container['cache'] = function ($c) {
    $settings = $c->get('settings')['fileAdapterCache'];
    return new FileCacheProvider($settings['namespace'], $settings['expires'], $settings['dir']);
};

/*
 * GuzzleHttp Client fot Http Requests
 */
$container['client'] = function () {
    return new Client();
};

/*
 * Bitly Provider
 */
$container['bitly'] = function ($c) {
    $bitly = $c->get('settings')['bitly'];
    $client  = $c->get('client');
    $cache = $c->get('cache');
    return new BitlyProvider($bitly['token'], $bitly['url'], $client, $cache);
};

/*
 * Rebrandly Provider
 */
$container['rebrandly'] = function ($c) {
    $rebrandly = $c->get('settings')['rebrandly'];
    $client  = $c->get('client');
    $cache = $c->get('cache');
    return new RebrandlyProvider($rebrandly['token'], $rebrandly['url'], $client, $cache);
};

/*
 * Validator Service Injected in the Controller
 * to do the parameter validation
 */
$container[ValidatorService::class] = function () {
    return new ValidatorService();
};

/*
 * ShortUrl Service Injected on the Controller
 * to do the heavy lifting
 */
$container[ShortUrlService::class] = function ($c) {
    return (new ShortUrlService($c, $c->get('request')))->setProvider();
};

/*
 * Default Controller to handle the requests
 */
$container[DefaultController::class] = function ($c) {
    $shortService  = $c->get(ShortUrlService::class);
    return new DefaultController($shortService);
};
