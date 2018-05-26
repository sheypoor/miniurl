<?php

namespace Miniurl\Tests;


use Miniurl\Database\Storage\RedisStorage;
use Miniurl\ShortUrl;
use Miniurl\UrlValidator;
use PHPUnit\Framework\TestCase;
use M6Web\Component\RedisMock\RedisMockFactory;

class ShortUrlTest extends TestCase
{
    private $shortUrl;
    private $redis;
    private $config =[
                        'baseUrl' => 'http://sheypoor.com',
                        'database' => 'redis',
                        'host' => 'localhost',
                        'port' => 6379,
                        'password' => null
                     ];

    public function setUp() :void
    {
        $factory          = new RedisMockFactory();
        $myRedisMockClass = $factory->getAdapter('Predis\Client', true);

        $this->redis = $this->getMockBuilder(RedisStorage::class)
            ->setMethods(array('__construct'))
            ->setConstructorArgs(array($this->config, $myRedisMockClass))
            ->getMock();

        $this->shortUrl = new ShortUrl($this->redis , new UrlValidator());
    }

    public function tearDown() :void
    {
        unset($this->shortUrl);
    }

    public function urlDataProvider() :array {
        return array(
            array('https://www.sheypoor.com/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86/%DA%A9%D8%B3%D8%A8-%DA%A9%D8%A7%D8%B1','0503acb8e8'),
            array('https://www.sheypoor.com/%DA%A9%D9%BE%D8%B3%D9%88%D9%84-%D9%BE%DB%8C%DA%A9%D9%86%DB%8C%DA%A9-52836998.html','7a3c06e576'),
            array('https://www.sheypoor.com/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86/%D9%84%D9%88%D8%A7%D8%B2%D9%85-%D8%AE%D8%A7%D9%86%DA%AF%DB%8C','1ded24c6b6'),
        );
    }

    /**
     * @dataProvider urlDataProvider
     * @param $url
     * @param $hash
     */

    public function testInsertShortCodeInDataBase($url, $hash) :void
    {

        $this->assertEquals($this->config['baseUrl']."/".$hash, $this->shortUrl->insertShortCodeInDataBase($url));
    }

    /**
     * @dataProvider urlDataProvider
     * @param $url
     * @param $hash
     */
    public function testGetUrl($url, $hash) :void
    {

        $this->assertEquals($url, $this->shortUrl->getUrl($hash));
    }

    public function hashDataProvider() :array {
        return array(
            array('0503acb8e8',0),
            array('7a3c06e576',0),
            array('1ded24c6b6',0),
        );
    }


    /**
     * @dataProvider hashDataProvider
     * @param $hash
     * @param $exception
     */
    public function testGetHashStats($hash, $exception) :void
    {

        $this->assertEquals($exception,$this->shortUrl->getHashStats($hash));
    }

    public function increaseDataProvider() :array {
        return array(
            array('0503acb8e8',1),
            array('7a3c06e576',1),
            array('1ded24c6b6',1),
        );
    }

}
