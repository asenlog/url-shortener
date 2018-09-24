<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 22/09/2018
 * Time: 22:32
 */

namespace App\Interfaces;

interface CacheInterface
{
    public function writeToCache(string $key, $value);

    public function readFromCache(string $key);
}
