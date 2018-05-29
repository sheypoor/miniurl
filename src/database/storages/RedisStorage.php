<?php
namespace Miniurl\Database\Storage;

use Miniurl\Database\StorageInterface;
use Predis;

class RedisStorage implements StorageInterface
{

    protected $client;
    protected $baseUrl;

    public function __construct(array $config, Predis\Client $client)
    {
        $this->baseUrl = $config['baseUrl'];
        $this->client = $client;

    }

    public function store(string $hash, string $url) :string
    {
        if (empty($this->checkHash($hash))) {

            $this->client->hmset($hash, [
                'url' => $url,
                'shortedUrl'=> $this->baseUrl."/".$hash,
                'count' => 0,
            ]);
        }

        return $this->baseUrl."/".$hash;
    }

    public function getCount(string $hash) : ?string
    {
        return $this->client->hget($hash, 'count');
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function incCount(string $hash) : ?string
    {
        if (empty($this->checkHash($hash))) {

            return 'Hash Does NOT Exist';
        }
        return $this->client->hincrby($hash, 'count', 1);
    }


    public function getUrlByHash(string $hash) : ?string
    {
        return $this->client->hget($hash, 'url');
    }

    public function checkHash(string $hash) :array
    {
        return $this->client->hgetall($hash);
    }
}
