<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once "mysqldb.php";

use PhpAmqpLib\Connection\AMQPStreamConnection;
$channelName = 'urls';

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare($channelName, false, true, false, false);

$mysqlDb = new MysqlDB();

$callback = function($msg) use($mysqlDb) {
    $url = $msg->body;
    $contentLength = strlen(file_get_contents($url));
    echo " Url: ". $url. " Content length: " . $contentLength . "\n";

    if($mysqlDb->isConnected()) {
        $mysqlDb->insertUrl(['url' => $url, 'content_length' => $contentLength]);
    }

    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_consume($channelName, '', false, false, false, false, $callback);

while($channel->is_open()) {
    $channel->wait();
}