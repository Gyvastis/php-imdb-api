<?php

namespace IMDb;

class Anonymizer
{
    private $anonymizerUrl = 'http://anonymouse.org/cgi-bin/anon-www.cgi/';

    /**
     * @param string $url
     * @return string $url
     */
    public function getAnonymizedUrl($url)
    {
        return $this->anonymizerUrl . $url;
    }
}