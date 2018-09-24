<?php
// DIC configuration
use App\Controllers\DefaultController;
use App\Providers\BitlyProvider;
use App\Providers\RebrandlyProvider;
use App\Services\ShortUrlService;
use App\Services\ValidatorService;
use GuzzleHttp\Client;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

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
    return new FilesystemAdapter();
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
    return new BitlyProvider($bitly['token'], $bitly['url'], $client);
};

/*
 * Rebrandly Provider
 */
$container['rebrandly'] = function ($c) {
    $rebrandly = $c->get('settings')['rebrandly'];
    $client  = $c->get('client');
    return new RebrandlyProvider($rebrandly['token'], $rebrandly['url'], $client);
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
    $validator  = $c->get(ValidatorService::class);
    $shortService  = $c->get(ShortUrlService::class);
    return new DefaultController($validator, $shortService);
};
