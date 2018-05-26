<?php

namespace Miniurl;

class UrlValidator implements Validator
{

    /**
     * @param $url
     * @return mixed
     */
    private static function validateUrlFormat(string $url)  {
        return filter_var($url, FILTER_VALIDATE_URL,
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

    /**
     * @param $url
     * @return bool
     */
    private static function verifyUrlExists(string $url) :bool {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
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

    /**
     * @param $url
     * @return bool
     */
    public static function validateUrl(string $url) :bool {
        if (self::validateUrlFormat($url) == false) {
            return false;
        }

        if (self::verifyUrlExists($url) == false) {
            return false;
        }

        return true;

    }

}
