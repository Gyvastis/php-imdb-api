<?php

namespace IMDb;

class IMDb
{
    /**
     * @var RequestHandler
     */
    private $requestHandler;

    /**
     * @var MovieResponseParser
     */
    private $movieResponseParser;

    /**
     * @var Anonymizer
     */
    private $anonymizer;

    /**
     * @var string
     */
    private $imdbMovieUrl = 'http://www.imdb.com/title/tt%s/';

    /**
     * IMDb constructor.
     * @param RequestHandler $requestHandler
     * @param MovieResponseParser $movieResponseParser
     * @param Anonymizer $anonymizer
     */
    public function __construct(RequestHandler $requestHandler, MovieResponseParser $movieResponseParser, Anonymizer $anonymizer)
    {
        $this->requestHandler = $requestHandler;
        $this->movieResponseParser = $movieResponseParser;
        $this->anonymizer = $anonymizer;
    }

    public function getMovieDetailsById($moveId, $anonymize = true)
    {
        $movieUrl = sprintf($this->getImdbMovieUrl(), $moveId);

        if($anonymize){
            $movieUrl = $this->getAnonymizer()->getAnonymizedUrl($movieUrl);
        }

        try {
            $rawMovieResponse = $this->getRequestHandler()->processRequestUrl($movieUrl);

            return $this->getMovieResponseParser()->parseCurlResponseToJson(
                $rawMovieResponse,
                $anonymize ? $this->getAnonymizer() : null
            );
        }
        catch(CurlException $ex){
            var_dump($ex->getMessage());

            return false;
        }
    }

    /**
     * @return string
     */
    public function getImdbMovieUrl()
    {
        return $this->imdbMovieUrl;
    }

    /**
     * @return RequestHandler
     */
    public function getRequestHandler()
    {
        return $this->requestHandler;
    }

    /**
     * @return MovieResponseParser
     */
    public function getMovieResponseParser()
    {
        return $this->movieResponseParser;
    }

    /**
     * @return Anonymizer
     */
    public function getAnonymizer()
    {
        return $this->anonymizer;
    }
}