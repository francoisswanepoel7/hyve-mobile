<?php


namespace hyvemobile\utils;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Cache\Adapter\RedisTagAwareAdapter;

class Cache
{
    private RedisTagAwareAdapter $cache;
    function __construct() {
        $client = RedisAdapter::createConnection('redis://localhost');
        $this->cache = new RedisTagAwareAdapter($client);
    }

    public function getCache() {
        return $this->cache;
    }

}
