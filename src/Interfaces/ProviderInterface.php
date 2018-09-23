<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 22/09/2018
 * Time: 15:43
 */

namespace App\Interfaces;

interface ProviderInterface
{
    public function isRequestedProvider(string $name);

    public function doShort(string $longUrl);

    public function getResponse();
}
