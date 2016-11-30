<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

$imdb = new \IMDb\IMDb(new \IMDb\RequestHandler(), new \IMDb\MovieResponseParser(), new \IMDb\Anonymizer());

// Actual movie URL being http://www.imdb.com/title/tt1431045/
$movieDetailsJson = $imdb->getMovieDetailsById('1431045', true);

var_dump($movieDetailsJson);