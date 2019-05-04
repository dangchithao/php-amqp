<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$config = require_once __DIR__ . '/../../runtime/cache/config.php';

try {
    $connection = new AMQPStreamConnection($config['host'], $config['port'], $config['username'], $config['password'], $config['v-host']);

    $channel = $connection->channel();

    $channel->queue_declare('thaodc', false, false, false, false);

    $message = new AMQPMessage('Hello World!');

    $channel->basic_publish($message, '', 'thaodc');

    echo " [x] Sent 'Hello World!'\n";

    $channel->close();
    $connection->close();
} catch (Exception $e) {
    // handle exception
}

