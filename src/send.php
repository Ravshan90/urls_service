<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

$channelName = 'urls';
$urls = [
  'https://mail.ru',
  'https://habr.com',
  'https://www.youtube.com',
  'https://www.ya.ru',
  'https://lenta.ru',
  'https://www.google.com',
  'https://alfabank.ru',
  'https://vk.com',
  'https://www.sports.ru',
  'https://market-delivery.yandex.ru'
];
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare($channelName, false, true, false, false);

foreach($urls as $url) {
    $msg = new AMQPMessage($url);
    $delay = rand(5, 30);
    $channel->basic_publish($msg, '', $channelName);
    $msg->set('application_headers', new AMQPTable(['x-delay' => $delay*1000]));
}



$channel->close();
$connection->close();
