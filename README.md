# php-imdb-api
A simple & lightweight IMDb movie details scraper with an anonymizer.

Example usage:
```php
require_once 'vendor/autoload.php';

$imdb = new \IMDb\IMDb(new \IMDb\RequestHandler(), new \IMDb\MovieResponseParser(), new \IMDb\Anonymizer());

// Actual movie URL being http://www.imdb.com/title/tt1431045/
$movieDetailsJson = $imdb->getMovieDetailsById('1431045', true);

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
   ],
   "cover_photo":"https:\/\/images-na.ssl-images-amazon.com\/images\/M\/MV5BMjQyODg5Njc4N15BMl5BanBnXkFtZTgwMzExMjE3NzE@._V1_UY1200_CR96,0,630,1200_AL_.jpg"
}
```