<?php
namespace hyvemobile\utils;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Cache\Adapter\RedisTagAwareAdapter;

class Domain
{
//    private FilesystemAdapter $cache;
//    private RedisTagAwareAdapter $cache;
    private $cache;
    function __construct(Cache $cache) {
//        $this->cache = new FilesystemAdapter('domain',0,'cache');
//        $client = RedisAdapter::createConnection('redis://localhost');
//        $this->cache = new RedisTagAwareAdapter($client);
        $this->cache = $cache->getCache();

    }

    public function getIP(string $domain) {
        $ip = '';
        try {
            $ip = $this->cache->get($domain, function (ItemInterface $item) use ($domain) {
                $item->expiresAfter(84600);
                return gethostbyname($domain);
            });
        } catch (InvalidArgumentException $e) {
        }
        return $ip;
    }



}
