<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

Dotenv::create(__DIR__ . '/../')->load();

$url = parse_url(getenv('CLOUDAMQP_URL'));

$vhost = substr($url['path'], 1);

return [
    'host' => $url['host'] ?? null,
    'port' => 5672,
    'username' => $url['user'] ?? null,
    'password' => $url['pass'] ?? null,
    'v-host' => $vhost ?? null
];
