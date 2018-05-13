<?php
namespace Miniurl\Database;

abstract class AbstractStorageFactory
{
    abstract function getStorage($param,$config);
}