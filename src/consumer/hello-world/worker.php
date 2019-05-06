<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$config = require_once __DIR__ . '/../../../runtime/cache/config.php';

try {
    $connection = new AMQPStreamConnection($config['host'], $config['port'], $config['username'], $config['password'], $config['v-host']);

    $channel = $connection->channel();

    $channel->queue_declare('thaodc', false, false, false, false);

    $channel->basic_consume('thaodc', '', false, true, false, false, function($message) {
        echo ' [x] Received ', $message->body, "\n";
    });

    while (count($channel->callbacks)) {
        $channel->wait();
    }

    $channel->close();
    $connection->close();
} catch (Exception $e) {
    // handle exception
}


