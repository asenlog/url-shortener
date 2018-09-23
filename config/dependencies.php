<?php
// DIC configuration
use App\Controllers\DefaultController;
use App\Providers\BitlyProvider;
use App\Providers\RebrandlyProvider;
use App\Services\ShortUrlService;
use App\Services\ValidatorService;
use GuzzleHttp\Client;
use Symfony\Component\Cache\Simple\FilesystemCache;

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
 * Symfony Cache Client
 */
$container['cache'] = function () {
    return new FilesystemCache();
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
$container[BitlyProvider::class] = function ($c) {
    $bitly = $c->get('settings')['bitly'];
    $client  = $c->get('client');
    return new BitlyProvider($bitly['token'], $bitly['url'], $client);
};

/*
 * Rebrandly Provider
 */
$container[RebrandlyProvider::class] = function ($c) {
    $rebrandly = $c->get('settings')['rebrandly'];
    $client  = $c->get('client');
    return new RebrandlyProvider($rebrandly['token'], $rebrandly['url'], $client);
};

/*
 * Registerd Providers  Injected in our Service to use
 */
$container['providers'] = function ($c) {
    $providers[] = $c->get(BitlyProvider::class);
    $providers[] = $c->get(RebrandlyProvider::class);
    return $providers;
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
    $providers = $c->get('providers');
    return new ShortUrlService($providers);
};

/*
 * Default Controller to handle the requests
 */
$container[DefaultController::class] = function ($c) {
    $validator  = $c->get(ValidatorService::class);
    $shortService  = $c->get(ShortUrlService::class);
    return new DefaultController($validator, $shortService);
};






