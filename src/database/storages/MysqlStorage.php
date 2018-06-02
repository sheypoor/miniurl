<?php
namespace Miniurl\Database\Storage;

use Miniurl\Database\StorageInterface;

class MysqlStorage implements StorageInterface
{

    private $config;
    private $client;

    public function __construct($config, $client)
    {
        $this->config = $config;
        $this->client = $client;
    }


    public function store(string $hash, string $url) :string
    {
        // TODO: Implement store() method.
    }

    public function getCount(string $hash) :?string
    {
        // TODO: Implement getCount() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function incCount(string $hash) :?string
    {
        // TODO: Implement incCount() method.
    }

    public function getUrlByHash(string $hash) :?string
    {
        // TODO: Implement getUrlByHash() method.
    }

    public function checkHash(string $hash) :array
    {
        // TODO: Implement checkHash() method.
    }
}
