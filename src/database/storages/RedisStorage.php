<?php
namespace Miniurl\Database\Storage;

use Miniurl\Database\StorageInterface;
use Predis;

class RedisStorage implements StorageInterface
{
    private $config;
    private $client;
    public function __construct($config)
    {
        $this->config = $config;

        Predis\Autoloader::register();
        $this->client = new Predis\Client($config);

    }

    public function store($hash,$url)
    {
        $this->client->hmset($hash, [
            'url' => $url,
            'count' => 0,
        ]);

        return $hash;
    }

    public function getCount($hash)
    {
        return $this->client->hget($hash, 'count');
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function incCount($hash)
    {
        $this->client->hincrby($hash, 'count', 1);
    }


    public function getUrlByHash($hash)
    {
        return $this->client->hget($hash, 'url');
    }

    public function checkHash($hash)
    {
        return $this->client->hgetall($hash);
    }
}