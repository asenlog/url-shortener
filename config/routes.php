<?php

use App\Controllers\DefaultController;

// Routes
$app->post('/shorten', DefaultController::class . ":shortUrl")->add($validate);

$app->get('/swagger', function ($request, $response, $args) {
    $str = file_get_contents(__DIR__ . '/../build/docs/openapi.json');
    return $response->withJson(json_decode($str));
});
