# php-imdb-api
A simple & lightweight IMDb movie details scraper with an anonymizer.

```php
require_once 'vendor/autoload.php';

$imdb = new \IMDb\IMDb(new \IMDb\RequestHandler(), new \IMDb\MovieResponseParser(), new \IMDb\Anonymizer());

$movieDetailsJson = $imdb->getMovieById('1431045', true);

var_dump($movieDetailsJson);
```

Example output:
```

```