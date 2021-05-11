# nhymxu/php-floc-disable

[![packagist](https://img.shields.io/packagist/v/nhymxu/php-floc-disable.svg?style=flat-square)](https://packagist.org/packages/nhymxu/php-floc-disable)
[![phpunit](https://github.com/nhymxu/php-floc-disable/actions/workflows/phpunit.yml/badge.svg?branch=main)](https://github.com/nhymxu/php-floc-disable/actions/workflows/phpunit.yml)

PHP middleware to disable Google's Federated Learning of Cohorts (`FLoC`) tracking

## Usage

This package is installable and auto-loadable via Composer as nhymxu/php-floc-disable.

```shell
composer require nhymxu/php-floc-disable
```

### Slim 4 integration

Add the `FlocDisableMiddleware` to set the header

Example: `public/index.php`

```php
<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Nhymxu\FlocDisable\FlocDisableMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Add Slim routing middleware
$app->addRoutingMiddleware();

// Set the header to disable FLoC.
$app->add(new FlocDisableMiddleware());

$app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('Hello, World!');
    return $response;
})->setName('root');

// Run app
$app->run();
```

## Support

* Issues: <https://github.com/nhymxu/php-floc-disable/issues>
* Here you can [donate](https://dungnt.net/donate.html) for this project.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
