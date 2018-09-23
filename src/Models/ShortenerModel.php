<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 22/09/2018
 * Time: 02:01
 */

namespace App\Models;

use App\Constants\Constants;
use Respect\Validation\Validator as v;

class ShortenerModel
{
    /**
     * Set the Bitly provider as the default.
     *
     * @var array
     */
    protected $parameters = [
        Constants::PARAMETER_PROVIDER => Constants::PARAMETER_PROVIDER_BITLY,
    ];

    protected $validators;

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setParameters($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * @return array
     */
    public function getValidators()
    {
        $this->validators[Constants::PARAMETER_URL] = v::url();
        $this->validators[Constants::PARAMETER_PROVIDER] = v::optional(v::oneOf(
            v::equals(Constants::PARAMETER_PROVIDER_BITLY),
            v::equals(Constants::PARAMETER_PROVIDER_REBRANDLY)
        ));
        return $this->validators;
    }

}