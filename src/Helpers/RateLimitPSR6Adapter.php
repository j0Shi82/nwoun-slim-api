<?php

declare(strict_types=1);

namespace App\Helpers;

class RateLimitPSR6Adapter extends \PalePurple\RateLimit\Adapter
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface;
     */
    private $pool;

    public function __construct(\Psr\Cache\CacheItemPoolInterface $pool)
    {
        $this->pool = $pool;
    }

    public function get($key)
    {
        $item = $this->pool->getItem($key);

        if ($item->isHit()) {
            return $item->get();
        }
        return (float) 0;
    }

    public function set($key, $value, $ttl)
    {
        $item = $this->pool->getItem($key);
        $item->set($value);
        $item->expiresAfter($ttl);
        return $this->pool->save($item);
    }

    public function exists($key)
    {
        return $this->pool->hasItem($key);
    }

    public function del($key)
    {
        return $this->pool->deleteItem($key);
    }
}
