<?php

namespace Miniurl\Tests;


use Miniurl\Database\StorageFactory;
use Miniurl\ShortUrl;
use PHPUnit\Framework\TestCase;
use Miniurl\Database\StorageInterface;

class ShortUrlTest extends TestCase
{
    private $shortUrl;

    private $baseUrl;
    private $config = [
        'host' => 'localhost',
        'port' => 6379,
        'password' => null
        ];
    public function setUp() :void
    {

        $this->baseUrl = "https://www.sheypoor.com/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86/%DA%A9%D8%B3%D8%A8-%DA%A9%D8%A7%D8%B1";
        $redisStorage = new StorageFactory();
        $redisStorage = $redisStorage->getStorage($redisStorage::REDIS, $this->config);

        $this->shortUrl = new  ShortUrl($redisStorage);

    }

    public function tearDown() :void
    {
        unset($this->shortUrl);
    }

    public function testCreateRepetitiveHash() :void
    {

        $this->assertEquals('0503acb8e8', $this->shortUrl->createRepetitiveHash($this->baseUrl));
    }

    public function testInsertShortCodeInDataBase() :void
    {
        $this->assertEquals('0503acb8e8',$this->shortUrl->insertShortCodeInDataBase($this->shortUrl->createRepetitiveHash($this->baseUrl), $this->baseUrl));
    }

    public function testGetUrl() :void
    {
        $this->assertEquals($this->baseUrl,$this->shortUrl->getUrl('0503acb8e8'));
    }

    public function testGetHashStats() :void
    {
        $this->assertEquals(0,$this->shortUrl->getHashStats('0503acb8e8'));
    }

    public function testHashIsAvailable() :void
    {
        $this->assertTrue($this->shortUrl->hashIsAvailable('0503acb8e8'));
    }

}