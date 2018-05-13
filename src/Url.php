<?php
namespace Miniurl;

class Url
{
    private $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;

    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }


    protected function validateUrlFormat() {
        return filter_var($this->baseUrl, FILTER_VALIDATE_URL,
            FILTER_FLAG_PATH_REQUIRED);

        /**
         * We USE FILTER_FLAG_PATH_REQUIRED
         *
         * FILTER_FLAG_PATH_REQUIRED
         * FILTER_FLAG_QUERY_REQUIRED
         * FILTER_FLAG_HOST_REQUIRED
         * FILTER_FLAG_SCHEME_REQUIRED
         */

    }

    protected function verifyUrlExists() {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response == 200) {
            return true;
        }

        return false;

    }


    public function validateUrl() {
        if ($this->validateUrlFormat() == false) {
            throw new \Exception("URL does not have a valid format.");
        }

        if ($this->verifyUrlExists() == false) {
            throw new \Exception("URL does not appear to exist.");
        }

        return true;

    }

}

$test = new Url("http://tarahbashi.com/%D8%A2%D9%85%D9%88%D8%B2%D8%B4-%DA%A9%D8%A7%D9%85%D9%84-%D9%BE%D8%B1%D8%B3%D9%BE%DA%A9%D8%AA%DB%8C%D9%88/");

$test->validateUrl();