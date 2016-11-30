<?php

namespace IMDb;

use Curl\Curl;

class RequestHandler
{
    /**
     * @param string $url
     * @param array $params
     * @return string
     * @throws CurlException
     */
    public function processRequestUrl($url, $params = [])
    {
        $curl = new Curl();
        $curl->setOpt(CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.98 Safari/537.36');
        $curl->setOpt(CURLOPT_FOLLOWLOCATION, true);

        $curl->get($url, $params);

        if ($curl->error) {
            throw new CurlException($curl->error_code . ': '. $curl->error_message);
        }

        return $curl->response;
    }
}