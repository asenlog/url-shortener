<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 22/09/2018
 * Time: 13:03
 */

namespace App\Constants;

class Constants
{
    /**
     * Contains all the Standard variables the application uses.
     * The idea behind this, is to have one central point of change
     *  across all our application.
     */

    // Parameters
    const PARAMETER_URL                         = 'url';
    const PARAMETER_PROVIDER                    = 'provider';
    const PARAMETER_PROVIDER_REBRANDLY          = 'rebrandly';
    const PARAMETER_PROVIDER_BITLY              = 'bitly';
    const PARAMETER_PROVIDER_DEFAULT            = 'bitly';

    // Response Text
    const RESPONSE_STATUS                       = 'status';
    const RESPONSE_MESSAGE                      = 'message';
    const RESPONSE_LONG_URL                     = 'longUrl';
    const RESPONSE_SHORT_URL                    = 'shortUrl';

    // Error Text
    const ERROR_INVALID_PARAMETER               = 'Invalid Parameter';
    const ERROR_BAD_REQUEST                     = 'Bad Request';
    const ERROR_SERVER_SIDE                     = 'Something Went Wrong..';
    const ERROR_NOT_FOUND                       = 'Route Not Found..';
    const ERROR_SERVICE_UNAVAILABLE             = 'Service Unavailable';
}
