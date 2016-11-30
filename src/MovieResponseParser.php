<?php

namespace IMDb;

use Symfony\Component\DomCrawler\Crawler;

class MovieResponseParser
{
    /**
     * @param string $rawMovieResponse
     * @param null|Anonymizer $anonymizer
     * @return array
     */
    public function parseCurlResponseToArray($rawMovieResponse, $anonymizer = null)
    {
        $crawler = new Crawler($rawMovieResponse);

        $title = $crawler->filter('#title-overview-widget h1')->first()->text();
        list($title, $year) = explode('&nbsp;', htmlentities($title));
        $title = trim($title);
        $year = preg_replace('/[^\d]+/i', '', $year);

        $description = $crawler->filter('#title-overview-widget .summary_text')->first()->text();
        $description = trim($description);

        $rating = $crawler->filter('#title-overview-widget span[itemprop="ratingValue"]')->first()->text();
        $rating_count = $crawler->filter('#title-overview-widget span[itemprop="ratingCount"]')->first()->text();
        $rating_count = str_replace(',', '', $rating_count);

        $genres = $crawler->filter('#titleStoryLine div[itemprop="genre"] > a')->each(function(Crawler $innerCrawler) {
            return trim($innerCrawler->text());
        });

        $keywords = $crawler->filter('#titleStoryLine div[itemprop="keywords"] span[itemprop="keywords"]')->each(function(Crawler $innerCrawler) {
            return trim($innerCrawler->text());
        });

        $cover_photo = $crawler->filter('link[rel="image_src"]')->attr('href');
        if($anonymizer !== null){
            $cover_photo = $anonymizer->getUnAnonymizedUrl($cover_photo);
        }

        $director = trim($crawler->filter('#title-overview-widget span[itemprop="director"]')->text());

        $writers = $crawler->filter('#title-overview-widget span[itemprop="creator"]')->each(function(Crawler $innerCrawler) {
            return trim($innerCrawler->text());
        });

        $stars = $crawler->filter('#title-overview-widget span[itemprop="actors"]')->each(function(Crawler $innerCrawler) {
            return trim($innerCrawler->text());
        });

        $movieDetailsArray = compact(
            'title',
            'year',
            'description',
            'rating',
            'rating_count',
            'genres',
            'keywords',
            'cover_photo',
            'director',
            'writers',
            'stars'
        );

        return $movieDetailsArray;
    }

    /**
     * @param string $rawMovieResponse
     * @param null|Anonymizer $anonymizer
     * @return string
     */
    public function parseCurlResponseToJson($rawMovieResponse, $anonymizer = null)
    {
        return json_encode($this->parseCurlResponseToArray($rawMovieResponse, $anonymizer));
    }
}