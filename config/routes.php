<?php

use App\Controllers\DefaultController;
use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->post('/shorten', DefaultController::class . ":shortUrl");
