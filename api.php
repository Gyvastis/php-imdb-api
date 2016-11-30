<?php

require_once 'vendor/autoload.php';

$imdb = new \IMDb\IMDb(new \IMDb\RequestHandler(), new \IMDb\MovieResponseParser(), new \IMDb\Anonymizer());

$movieDetailsJson = '';

if(@$_GET['movieId']) {
    $movieDetailsJson = $imdb->getMovieDetailsById($_GET['movieId'], true);
}

header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
echo json_encode($movieDetailsJson);