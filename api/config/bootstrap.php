<?php
use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions(__DIR__ . '/container.php');
$container = $containerBuilder->build();

$app = $container->get(App::class);
$app->setBasePath('/api');
(require_once __DIR__ . '/routes.php')($app);
(require_once __DIR__ . '/middleware.php')($app);

return $app;
