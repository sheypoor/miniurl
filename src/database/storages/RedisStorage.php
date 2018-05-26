<?php
namespace Miniurl\Database\Storage;

use Miniurl\Database\StorageInterface;


class RedisStorage implements StorageInterface
{

    protected $client;
    protected $baseUrl;

    public function __construct($config, $client)
    {
        $this->baseUrl = $config['baseUrl'];
        $this->client = $client;

    }

    public function store($hash, $url) :string
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

    public function getCount($hash) :string
    {
        return $this->client->hget($hash, 'count');
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function incCount($hash) :void
    {
        $this->client->hincrby($hash, 'count', 1);
    }


    public function getUrlByHash($hash) :string
    {
        return $this->client->hget($hash, 'url');
    }

    public function checkHash($hash) :array
    {
        return $this->client->hgetall($hash);
    }
}
