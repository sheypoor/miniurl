<?php
namespace Miniurl\Database;

use Miniurl\Database\Storage\MysqlStorage;
use Miniurl\Database\Storage\RedisStorage;
use Predis;
use PDO;
class StorageFactory extends AbstractStorageFactory
{
    const REDIS = 'redis';
    const MYSQL = 'mysql';


    public static function getStorage($config)
    {
        $database = NULL;
        switch ($config['database']) {
            case self::REDIS:
                unset($config['database']);
                Predis\Autoloader::register();
                $database = new RedisStorage($config, new Predis\Client($config));
                break;
            case self::MYSQL:
                $database = new MysqlStorage($config,new PDO($config));
                break;
            default:
                $database = new RedisStorage($config, new Predis\Client($config));
                break;
        }
        return $database;
    }
}