<?php
namespace Miniurl\Database\Storage;

use Miniurl\Database\StorageInterface;

class MysqlStorage implements StorageInterface
{

    private $config;
    private $client;
    public function __construct($config)
    {
        $this->config = $config;

        /*Predis\Autoloader::register();
        $this->client = new Predis\Client($config);*/

        //TODO Mysql Connection
    }


    public function store($hash, $url)
    {
        // TODO: Implement store() method.
    }

    public function getCount($hash)
    {
        // TODO: Implement getCount() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function incCount($hash)
    {
        // TODO: Implement incCount() method.
    }

    public function getUrlByHash($hash)
    {
        // TODO: Implement getUrlByHash() method.
    }

    public function checkHash($hash)
    {
        // TODO: Implement checkHash() method.
    }
}