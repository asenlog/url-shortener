<?php
// Application middleware
use App\Constants\Constants;

/**
 *  Middleware closure validating the Headers and request parameters.
 *
 * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
 * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
 * @param  callable                                 $next     Next middleware
 *
 * @return \Psr\Http\Message\ResponseInterface
 */

$validate = function ($request, $response, $next) {
    $contentType = $request->getHeader('HTTP_CONTENT_TYPE');
    $shortenerModel = new \App\Models\ShortenerModel();
    $validatorService = new \App\Services\ValidatorService();

    $isValid = $validatorService->validate(
        $request->getParsedBody(),
        $shortenerModel->getValidators()
    );

    if ($isValid->failed() || ($contentType[0] !== "application/x-www-form-urlencoded")) {
        return $response
            ->withStatus(400)
            ->withJson([
                Constants::RESPONSE_STATUS => 400,
                Constants::RESPONSE_MESSAGE => Constants::ERROR_BAD_REQUEST
            ]);
    }

    $response = $next($request, $response);
    return $response;
};
