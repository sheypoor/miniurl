<?php
namespace Miniurl\Tests;

use Miniurl\UrlValidator;
use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    private $url;
    public function setUp() :void
    {
        $this->url = new UrlValidator();
    }

    public function tearDown() :void
    {
        unset($this->url);
    }

    public function urlDataProvider() :array
    {
        return array(
            array('https://www.sheypoor.com/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86/%DA%A9%D8%B3%D8%A8-%DA%A9%D8%A7%D8%B1',true),
            array('https://www.sheypoor.com/%DA%A9%D9%BE%D8%B3%D9%88%D9%84-%D9%BE%DB%8C%DA%A9%D9%86%DB%8C%DA%A9-52836998.html',true),
            array('https://www.sheypoor.com/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86/%D9%84%D9%88%D8%A7%D8%B2%D9%85-%D8%AE%D8%A7%D9%86%DA%AF%DB%8C',true),
            array('https://www.sheypoor.com/%D8%A74%D9%88%D8%A7%D8%B2%D9%85-%D8%AE%D8%A7%D9%86%DA%AF%DB%8C',false),
            array('www.sheypoor.com/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86/%D9%84%D9%88%D8%A7%D8%B2%D9%85-%D8%AE%D8%A7%D9%86%DA%AF%DB%8C',false),
            array('www.sheypoor/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86/%D9%84%D9%88%D8%A7%D8%B2%D9%85-%D8%AE%D8%A7%D9%86%DA%AF%DB%8C',false),
        );
    }

    /**
     * @dataProvider urlDataProvider
     */
    public function testValidateUrl($url, $exception) :void
    {
        $this->assertEquals($exception, $this->url->validateUrl($url));
    }
}
