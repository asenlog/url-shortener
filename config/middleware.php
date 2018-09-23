<?php
// Application middleware

use App\Constants\Constants;

/**
 *  Middleware closure validating the Headers here but we could also validate the parameters
 * but for demonstration purposes choose to split them up.
 *
 * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
 * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
 * @param  callable                                 $next     Next middleware
 *
 * @return \Psr\Http\Message\ResponseInterface
 */

$app->add(function ($request, $response, $next) {

    if (!strpos($request->getUri(), 'swagger')) {
        $contentType = $request->getHeader('HTTP_CONTENT_TYPE');
        if ($contentType[0] !== "application/x-www-form-urlencoded") {
            return $response
                ->withStatus(400)
                ->withJson([
                    Constants::RESPONSE_STATUS => 400,
                    Constants::RESPONSE_MESSAGE => Constants::ERROR_BAD_REQUEST
                ]);
        }
    }

    $response = $next($request, $response);
    return $response;
});
