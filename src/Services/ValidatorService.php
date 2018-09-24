<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 22/09/2018
 * Time: 01:23
 */

namespace App\Services;

use App\Constants\Constants;
use Respect\Validation\Exceptions\NestedValidationException;

class ValidatorService
{
    protected $errors;

    /**
     * Validation of the parameters based on the
     * validation rules inside the model (App/Models/ShortenerModel) passing dynamically.
     *
     * @param array $params
     * @param array $rules
     * @return ValidatorService
     */
    public function validate($params, array $rules)
    {
        /**
         * Check if we have extra parameters.
         * Each parameter has a rule if they do not add up fail Validation.
         *
         */
        if (count($params) != count($rules)) {
            $this->errors['parameterCount'] = Constants::ERROR_INVALID_PARAMETER;
            return $this;
        }

        foreach ($rules as $field => $rule) {
            try {
                $rule->setName($field)->assert($params[$field]);
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }
        return $this;
    }

    /**
     * Check if we have any errors, so we can fail.
     *
     * @return bool
     */
    public function failed()
    {
        return !empty($this->errors);
    }
}