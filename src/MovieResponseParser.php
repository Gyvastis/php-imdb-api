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

        $rating = $crawler->filter('span[itemprop="ratingValue"]')->first()->text();
        $rating_count = $crawler->filter('span[itemprop="ratingCount"]')->first()->text();
        $rating_count = str_replace(',', '', $rating_count);

        $categories = $crawler->filter('span[itemprop="genre"]')->each(function(Crawler $innerCrawler) {
            return trim($innerCrawler->text());
        });

        return json_encode(compact(
            'title',
            'year',
            'description',
            'rating',
            'rating_count',
            'categories'
        ));
    }
}