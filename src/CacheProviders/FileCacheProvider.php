<?php
/**
 * Created by PhpStorm.
 * User: asenlog
 * Date: 23/09/2018
 * Time: 13:12
 */

namespace App\CacheProviders;

use App\Interfaces\CacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class FileCacheProvider extends FilesystemAdapter implements CacheInterface
{
    public function __construct(string $namespace = '', int $defaultLifetime = 0, string $directory = null)
    {
        parent::__construct($namespace, $defaultLifetime, $directory);
    }

    public function writeToCache(string $key, $value)
    {
        $item = $this->getItem($key);
        if (!$item->isHit()) {
            $item->set($value);
            $this->save($item);
        }
    }

    public function readFromCache(string $key)
    {
        if ($this->hasItem($key)) {
            $res = $this->getItem($key);
            return $res->get();
        }
        return null;
    }
}
