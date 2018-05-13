<?php
namespace Miniurl\Database;

use Miniurl\Database\Storage\MysqlStorage;
use Miniurl\Database\Storage\RedisStorage;

class StorageFactory extends AbstractStorageFactory
{
    const REDIS = 'redis';
    const MYSQL = 'mysql';


    public function getStorage($param,$config)
    {
        $database = NULL;
        switch ($param) {
            case $this::REDIS :
                $database = new RedisStorage($config);
                break;
            case $this::MYSQL:
                $database = new MysqlStorage($config);
                break;
            default:
                $database = new RedisStorage($config);
                break;
        }
        return $database;
    }
}