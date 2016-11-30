<?php

namespace IMDb;

use Symfony\Component\DomCrawler\Crawler;

class MovieResponseParser
{
    public function parseCurlResponseToJson($rawMovieResponse)
    {
        $crawler = new Crawler($rawMovieResponse);

        $title = $crawler->filter('.title_wrapper h1')->first()->text();
        list($title, $year) = explode('&nbsp;', htmlentities($title));
        $title = trim($title);
        $year = preg_replace('/[^\d]+/i', '', $year);

        $description = $crawler->filter('.summary_text')->first()->text();
        $description = trim($description);

        return json_encode(compact('title', 'year', 'description'));
    }
}