<?php
namespace Miniurl\Tests;

use Miniurl\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    private $url;
    public function setUp() :void
    {
        $this->url = new Url("https://www.sheypoor.com/%D8%A7%D9%86%D9%88%D8%A7%D8%B9-%DA%A9%D8%A7%D9%86%D8%A7%D9%84-%D9%87%D9%88%D8%A7-%D9%88%D8%AF%D8%B1%DB%8C%DA%86%D9%87-%D8%AA%D9%86%D8%B8%DB%8C%D9%85-%D9%87%D9%88%D8%A7-%D8%A8%D8%A7%D8%B2%DB%8C%D8%AF-%D8%B1%D8%A7%DB%8C%DA%AF%D8%A7%D9%86-50124992.html");
    }

    public function tearDown() :void
    {
        unset($this->url);
    }

    public function testValidateUrl() :void
    {
        $this->assertTrue($this->url->validateUrl(),"The URL IS NOT VALID");
    }

}