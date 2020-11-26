<?php

use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return function (App $app) {
  $app->addBodyParsingMiddleWare();
  $app->addRoutingMiddleware();
  $app->add(ErrorMiddleware::class);
};