<?php

use App\Controllers\DefaultController;

// Routes
$app->post('/shorten', DefaultController::class . ":shortUrl");
$app->get('/swagger', DefaultController::class . ":swagger");
