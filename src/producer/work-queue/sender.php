<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$config = require_once __DIR__ . '/../../../runtime/cache/config.php';

try {
    $connection = new AMQPStreamConnection($config['host'], $config['port'], $config['username'], $config['password'], $config['v-host']);

    $channel = $connection->channel();

    $channel->queue_declare('thaodc_durable', false, true, false, false);

    $data = implode(' ', array_slice($argv, 1));

    if (empty($data)) {
        $data = 'Hello World, I am work queue';
    }

    $message = new AMQPMessage(
        $data,
        [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]
    );

    $channel->basic_publish($message, '', 'thaodc_durable');

    echo " [x] Sent '{$data}'\n";

    $channel->close();
    $connection->close();
} catch (Exception $e) {
    // handle exception
}

