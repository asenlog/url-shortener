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
    private $validator;
    private $provider;

    public function __construct(
        ValidatorService $validator,
        ProviderInterface $provider
    ) {
        $this->validator = $validator;
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
         * Validate Incoming Data
         * Header Validation is happening on the middleware.
         * Just for demonstration purposes decided the split them up.
         *
         * Validation rules live inside the model.
         */
        $shortenerModel = new ShortenerModel();
        foreach ($request->getParsedBody() as $key => $value) {
            $shortenerModel->setParameters($key, $value);
        }

        $validator = $this->validator->validate(
            $shortenerModel->getParameters(),
            $shortenerModel->getValidators()
        );

        if ($validator->failed()) {
            return $response
                ->withStatus(400)
                ->withJson([
                    Constants::RESPONSE_STATUS => 400,
                    Constants::RESPONSE_MESSAGE => Constants::ERROR_INVALID_PARAMETER
                ]);
        }

        /*
         * Call the Service to do the heavy lifting
         */
        $this->provider->doShort($request->getParsedBodyParam('url'));
        $res = $this->provider->getResponse();

        /*
         * Return the response
         */
        return $response
            ->withStatus($res[Constants::RESPONSE_STATUS])
            ->withJson($res);
    }

    /**
     * Display the swagger.json file
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function swagger($request, $response)
    {
        $str = file_get_contents(__DIR__ . '/../../build/docs/openapi.json');
        return $response->withJson(json_decode($str));
    }

}