<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$config = require_once __DIR__ . '/../../../runtime/cache/config.php';

try {
    $connection = new AMQPStreamConnection($config['host'], $config['port'], $config['username'], $config['password'], $config['v-host']);

    $channel = $connection->channel();

    $channel->exchange_declare($config['queue']['exchange-name'], 'fanout', false, false, false);

//    $channel->queue_declare('thaodc_durable_exchange', false, true, false, false);
    [$queue_name] = $channel->queue_declare('', false, false, true, false);

    $channel->queue_bind($queue_name, $config['queue']['exchange-name']);

    // setting Fair dispatch: This tells RabbitMQ not to give more than one message to a worker at a time
    // Or, in other words, don't dispatch a new message to a worker until it has processed and acknowledged the previous one.
    // Instead, it will dispatch it to the next worker that is not still busy.
//    $channel->basic_qos(null, 1, null);

    echo " [*] Waiting for logs. To exit press CTRL+C\n";

    /**
     *  Setting the fourth parameter to basic_consume() to false (true means no ack)
     */
    $channel->basic_consume(
        $queue_name,
        '',
        false,
        false,
        false,
        false,
        function(AMQPMessage $message) {
            echo ' [x] ', $message->body, "\n";
        }
    );

    while (count($channel->callbacks)) {
        $channel->wait();
    }

    $channel->close();
    $connection->close();
} catch (Exception $e) {
    // handle exception
}


