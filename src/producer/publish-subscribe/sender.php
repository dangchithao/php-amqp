<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$config = require_once __DIR__ . '/../../../runtime/cache/config.php';

try {
    $connection = new AMQPStreamConnection($config['host'], $config['port'], $config['username'], $config['password'], $config['v-host']);

    $channel = $connection->channel();

    // Exchange
    $channel->exchange_declare($config['queue']['exchange-name'], 'fanout', false, false, false);

//    $channel->queue_declare('thaodc_durable_exchange', false, true, false, false);

    $data = implode(' ', array_slice($argv, 1));

    if (empty($data)) {
        $data = 'Hello World, I am publish subscribe queue';
    }

//    $message = new AMQPMessage(
//        $data,
//        [
//            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
//        ]
//    );

    $message = new AMQPMessage($data);

    $channel->basic_publish($message, $config['queue']['exchange-name']);

    echo " [x] Sent '{$data}'\n";

    $channel->close();
    $connection->close();
} catch (Exception $e) {
    // handle exception
}

