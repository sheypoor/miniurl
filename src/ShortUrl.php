<?php
namespace Miniurl;

use Miniurl\Database\StorageInterface;


class ShortUrl
{

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function IncreaseHashCount ($hashKey) :void
    {
        $this->storage->incCount($hashKey);

    }

    public function getHashStats ($hashKey)
    {
        return $this->storage->getCount($hashKey);

    }


    public function hashIsAvailable($hashKey) :bool
    {
        if (empty($this->storage->checkHash($hashKey))) {
            return false;
        }

        return true;
    }

    public function getUrl($hashKey) :string
    {
        return $this->storage->getUrlByHash($hashKey);

    }

    public function insertShortCodeInDataBase($hash,$url)
    {

      return $this->storage->store($hash,$url) ;
    }

    public function createUniqueHash($url)
    {
        return substr(sha1(uniqid($url . mt_rand(), true)), 0, 10);
    }

    public function createRepetitiveHash($url)
    {
        return substr(sha1($url), 0, 10);
    }

}