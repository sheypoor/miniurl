<?php
namespace Miniurl\Database;

abstract class AbstractStorageFactory
{
    abstract static function getStorage(array $config);
}
