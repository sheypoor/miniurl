<?php

namespace Miniurl;

use Miniurl\Database\StorageInterface;

class ShortUrl
{
    protected $storage;
    protected $urlValidator;
    protected $config;

    /**
     * ShortUrl constructor.
     * @param $storage
     * @param UrlValidator $urlValidator
     * @internal param $config
     * @internal param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage , UrlValidator $urlValidator)
    {
        $this->storage = $storage;
        $this->urlValidator = $urlValidator;
    }

    /**
     * @param string $hashKey
     * @return null|string
     */
    public function increaseHashCount (string $hashKey) : ?string
    {
        return $this->storage->incCount($hashKey);

    }

    /**
     * @param string $hashKey
     * @return string
     */
    public function getHashStats (string $hashKey) : ?string
    {
        return $this->storage->getCount($hashKey);

    }

    /**
     * @param string $hashKey
     * @return bool
     */
    public function hashIsAvailable(string $hashKey) :bool
    {
        if (empty($this->storage->checkHash($hashKey))) {
            return false;
        }

        return true;
    }

    /**
     * @param string $hashKey
     * @return string
     */
    public function getUrl(string $hashKey) : ?string
    {
        return $this->storage->getUrlByHash($hashKey);

    }


    /**
     * @param string $url
     * @return string
     */
    public function insertShortCodeInDataBase(string $url) :?string
    {

        $hashUrl = $this->createRepetitiveHash($url);


        if (!empty($hashUrl)) {

            return $this->storage->store($this->createRepetitiveHash($url),$url);
        }

        return null;

    }


    /**
     * @param string $url
     * @return bool|string
     */
    private function createRepetitiveHash(string $url) :?string
    {

        if ($this->urlValidator::validateUrl($url)) {
            return substr(sha1($url), 0, 10);
        }

        return null ;
    }

}

