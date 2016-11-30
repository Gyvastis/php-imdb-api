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

        $cover_photo = $crawler->filter('link[rel="image_src"]')->attr('href');
        if($anonymizer !== null){
            $cover_photo = $anonymizer->getUnAnonymizedUrl($cover_photo);
        }

        $movieDetailsArray = compact(
            'title',
            'year',
            'description',
            'rating',
            'rating_count',
            'categories',
            'cover_photo'
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