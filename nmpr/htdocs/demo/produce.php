<?php


/***************************************************************************
 *
 * Copyright (c) 2020 doushen.com, Inc. All Rights Reserved
 *
 **************************************************************************/

// 多个共享消费者
/*require_once './vendor/autoload.php';
require_once './RabbitMQ.php';
use RabbitMQ\RabbitMQ;
use PhpAmqpLib\Message\AMQPMessage;
$rabbit = new RabbitMQ();
$queueName = 'test-single-queue';
$rabbit->createQueue($queueName, false, true, false, false);
for ($i = 0; $i < 10000; $i++) {
    $rabbit->sendMessage($i . "this is a test message.", $queueName, '', [
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT //消息持久化，重启rabbitmq，消息不会丢失
    ]);
}
unset($rabbit);//关闭连接*/


// 多个独立消费者
/*require_once './vendor/autoload.php';
require_once './RabbitMQ.php';
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\RabbitMQ;
$rabbit = new RabbitMQ();
$routingKey1 = 'test.ex.queue1';
$routingKey2 = 'test.ex.queue2';
$exchangeName = 'test-ex-topic';
$rabbit->createExchange($exchangeName, AMQPExchangeType::TOPIC, false, true, false);
for ($i=0;$i<10000;$i++) {
    $rabbit->sendMessage($i . "this is a queue1 message.", $routingKey1, $exchangeName, [
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
    ]);
}
for ($i=0;$i<10000;$i++) {
    $rabbit->sendMessage($i . "this is a queue2 message.", $routingKey2, $exchangeName, [
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
    ]);
}
unset($rabbit);*/


// 延时队列
require_once './vendor/autoload.php';
require_once './DelayQueue.php';
// 生产者
$delay = new \RabbitMQ\DelayQueue();
$ttl            = 1000 * 100;//订单100s后超时
$delayExName    = 'delay-order-exchange';//超时exchange
$delayQueueName = 'delay-order-queue';//超时queue
$queueName      = 'ttl-order-queue';//订单queue
$delay->createQueue2($ttl, $delayExName, $delayQueueName, $queueName);
//100个订单信息，每个订单超时时间都是10s
for ($i = 0; $i < 100; $i++) {
    $data = [
        'order_id' => $i + 1,
        'remark'   => 'this is a order test'
    ];
    $delay->sendMessage(json_encode($data), $queueName);
    sleep(1);
}