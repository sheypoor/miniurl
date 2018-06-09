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
                        'databaseType' => 'redis',
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

        $this->shortUrl = new ShortUrl($this->redis, new UrlValidator());
    }

    public function tearDown() :void
    {
        unset($this->shortUrl);
    }

    public function urlDataProvider() :array
    {
        return [
            ['https://www.sheypoor.com/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86/%DA%A9%D8%B3%D8%A8-%DA%A9%D8%A7%D8%B1',$this->config['baseUrl']."/".'0503acb8e8'],
            ['https://www.sheypoor.com/%DA%A9%D9%BE%D8%B3%D9%88%D9%84-%D9%BE%DB%8C%DA%A9%D9%86%DB%8C%DA%A9-52836998.html',$this->config['baseUrl']."/".'7a3c06e576'],
            ['https://www.sheypoor.com/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86/%D9%84%D9%88%D8%A7%D8%B2%D9%85-%D8%AE%D8%A7%D9%86%DA%AF%DB%8C',$this->config['baseUrl']."/".'1ded24c6b6'],
            ['https://www.sheypoor.com/%D8%A7%DB%8C%A7%D9%86/%D9%84%D9%88%D8%A7%D8%B2%D9%85-%D8%AE%D8%A7%D9%86%DA%AF%DB%8C',null ],
            ['sheypoor.com/%DA%A9%D9%BE%D8%B3%D9%88%D9%84-%D9%BE%DB%8C%DA%A9%D9%86%DB%8C%DA%A9-52836998.html',null ],
        ];
    }

    /**
     * @dataProvider urlDataProvider
     * @param $url
     * @param $hash
     */

    public function testInsertShortCodeInDataBase($url, $hash) :void
    {
        $this->assertEquals($hash, $this->shortUrl->insertShortCodeInDataBase($url));
    }


    public function getUrlDataProvider() :array
    {
        return [
            ['https://www.sheypoor.com/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86/%DA%A9%D8%B3%D8%A8-%DA%A9%D8%A7%D8%B1','0503acb8e8'],
            ['https://www.sheypoor.com/%DA%A9%D9%BE%D8%B3%D9%88%D9%84-%D9%BE%DB%8C%DA%A9%D9%86%DB%8C%DA%A9-52836998.html','7a3c06e576'],
            ['https://www.sheypoor.com/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86/%D9%84%D9%88%D8%A7%D8%B2%D9%85-%D8%AE%D8%A7%D9%86%DA%AF%DB%8C','1ded24c6b6'],
            [null,'1ded24s6bd'],
            [null,'1csd24s6bd'],
        ];
    }

    /**
     * @dataProvider getUrlDataProvider
     * @param $url
     * @param $hash
     */
    public function testGetUrl($url, $hash) :void
    {

        $this->assertEquals($url, $this->shortUrl->getUrl($hash));
    }

    public function hashDataProvider() :array
    {
        return [
            ['0503acb8e8',0],
            ['7a3c06e576',0],
            ['1ded24c6b6',0],
            ['1ded24c9b6',null],
            ['1de424c9b6',null],
        ];
    }

    /**
     * @dataProvider hashDataProvider
     * @param $hash
     * @param $exception
     */
    public function testGetHashStats($hash, $exception) :void
    {
        $this->assertEquals($exception, $this->shortUrl->getHashStats($hash));
    }
}
