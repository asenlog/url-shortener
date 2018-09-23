<?php

use App\Constants\Constants;

$container = $app->getContainer();

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']
            ->withStatus(404)
            ->withJson(array(
                Constants::RESPONSE_STATUS => 404,
                Constants::RESPONSE_MESSAGE => Constants::ERROR_NOT_FOUND
            ));
    };
};

//Override the default Not Allowed Handler
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $c['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withJson([
                Constants::RESPONSE_STATUS => 405,
                Constants::RESPONSE_MESSAGE => 'Allowed Methods: ' .implode(', ', $methods)
            ]);
    };
};

//Override the default PHP Errors Handler
$container['phpErrorHandler'] = function ($c) {
    return function ($request, $response, $error) use ($c) {
        return $c['response']
            ->withStatus(500)
            ->withJson([
                Constants::RESPONSE_STATUS => 500,
                Constants::RESPONSE_MESSAGE => Constants::ERROR_SERVER_SIDE
            ]);
    };
};
