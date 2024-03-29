<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 23/09/2018
 * Time: 19:03
 */

namespace Tests;

use App\Models\ShortenerModel;
use App\Services\ValidatorService;

class ValidatorServiceTest extends BaseTestCase
{
    private $validator;
    private $model;

    public function setUp()
    {
        $this->validator = new ValidatorService();
        $this->model = new ShortenerModel();
    }

    /**
     * Check that the Validator works as expected
     */

    /**
     * Test Valid rules
     * @test
     */
    public function testValidateValid()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'rebrandly'];
        $this->validator->validate($parameters, $this->model->getValidators());

        $this->assertFalse($this->validator->failed());
    }

    /**
     * Test invalid rules -> Extra parameter
     * @test
     */
    public function testValidatorExtraParam()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'bitly', 'test' => 1];
        $this->validator->validate($parameters, $this->model->getValidators());

        $this->assertTrue($this->validator->failed());
    }

    /**
     * Test invalid rules -> Wrong Provider Name
     * @test
     */
    public function testValidatorWrongProvider()
    {
        $parameters = ['url' => 'http://www.example.com', 'provider' => 'test'];
        $this->validator->validate($parameters, $this->model->getValidators());

        $this->assertTrue($this->validator->failed());
    }
}
