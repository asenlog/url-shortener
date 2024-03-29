<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class BaseTestCase extends TestCase
{
    /**
     * Use middleware when running application
     *
     * @var bool
     */
    protected $withMiddleware = true;

    /**
     * The app implementation.
     *
     * @var \Slim\App
     */
    protected $app;


    public function setUp()
    {
        if (!$this->app) {
            // Use the application settings
            $settings = require __DIR__ . '/../config/settings.php';
            // Instantiate the application
            $app = new App($settings);
            // Set up dependencies
            require __DIR__ . '/../config/dependencies.php';
            // Register middleware
            if ($this->withMiddleware) {
                require __DIR__ . '/../config/middleware.php';
            }
            // Register routes
            require __DIR__ . '/../config/routes.php';
            $this->app = $app;
        }
    }

    public function tearDown()
    {
        if ($this->app) {
            $this->app = null;
        }
    }

    /**
     * Process the application given a request method, URI and Params
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     *
     * @throws \Slim\Exception\MethodNotAllowedException
     * @throws \Slim\Exception\NotFoundException
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'CONTENT_TYPE' => 'application/x-www-form-urlencoded',
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();
        // Set the request environment to container
        $this->app->getContainer()['request'] = $request;
        // Process the application
        $response = $this->app->process($request, $response);
        // Return the response

        return $response;
    }
}
