<?php

error_reporting(0);
ini_set('display_errors', '0');

$settings = [];

$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

$settings['error'] = [
  'display_error_details' => true,
  'log_errors' => true,
  'log_error_details' => true,
];

$settings['db'] = [
  'driver' => 'mysql',
  'host' => 'localhost',
  'username' => $_ENV['DB_USERNAME'],
  'database' => 'ccpp',
  'password' => $_ENV['DB_PASSWORD'],
  'charset' => 'utf8mb4',
  'collection' => 'utf8mb4_unicode_ci',
  'flags' => [
    // Turn off persistent connections
    PDO::ATTR_PERSISTENT => false,
    // Enable exceptions
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // Emulate prepared statements
    PDO::ATTR_EMULATE_PREPARES => true,
    // Set default fetch mode to array
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Set character set
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
  ],
];

return $settings;
