<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 22/09/2018
 * Time: 20:53
 */

namespace App\Controllers;

use App\Constants\Constants;
use App\Interfaces\ProviderInterface;
use App\Models\ShortenerModel;
use App\Services\ValidatorService;

use Slim\Http\Request;
use Slim\Http\Response;

class DefaultController
{
    private $provider;

    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function shortUrl($request, $response)
    {
        /*
         * Validation of Incoming Data is taking
         * place in the middleware.
         *
         * Validation rules live inside the model.
         */

        /*
         * Call the Provider to do the heavy lifting
         */
        $res = $this->provider->doShort($request->getParsedBodyParam(Constants::PARAMETER_URL));

        /*
         * Return the response
         */
        return $response
            ->withStatus($res[Constants::RESPONSE_STATUS])
            ->withJson($res);
    }
}