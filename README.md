# php-imdb-api
A simple & lightweight IMDb movie details scraper with an anonymizer.

Example usage:
```php
require_once 'vendor/autoload.php';

$imdb = new \IMDb\IMDb(new \IMDb\RequestHandler(), new \IMDb\MovieResponseParser(), new \IMDb\Anonymizer());

$movieDetailsJson = $imdb->getMovieById('1431045', true);

var_dump($movieDetailsJson);
```

Example output:
```json
{
   "title":"Deadpool",
   "year":"2016",
   "description":"A fast-talking mercenary with a morbid sense of humor is subjected to a rogue experiment that leaves him with accelerated healing powers and a quest for revenge.",
   "rating":"8.1",
   "rating_count":"544384",
   "categories":[
      "Action",
      "Adventure",
      "Comedy"
   ]
}
```