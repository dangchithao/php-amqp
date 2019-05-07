<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$config = require_once __DIR__ . '/../../../runtime/cache/config.php';

try {
    $connection = new AMQPStreamConnection($config['host'], $config['port'], $config['username'], $config['password'], $config['v-host']);

    $channel = $connection->channel();

    $channel->queue_declare('thaodc_durable', false, true, false, false);

    // setting Fair dispatch: This tells RabbitMQ not to give more than one message to a worker at a time
    // Or, in other words, don't dispatch a new message to a worker until it has processed and acknowledged the previous one.
    // Instead, it will dispatch it to the next worker that is not still busy.
    $channel->basic_qos(null, 1, null);

    /**
     *  Setting the fourth parameter to basic_consume() to false (true means no ack)
     */
    $channel->basic_consume(
        'thaodc_durable',
        '',
        false,
        false,
        false,
        false,
        function(AMQPMessage $message) {
            echo "[x] Received {$message->body}\n";
            sleep(substr_count($message->body, '.'));
            echo "[x] Done \n";

            // re-queue
            $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
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


