<?php


/***************************************************************************
 *
 * Copyright (c) 2020 doushen.com, Inc. All Rights Reserved
 *
 **************************************************************************/


// 多个共享消费者
/*require_once "./vendor/autoload.php";
require_once "./RabbitMQ.php";
use RabbitMQ\RabbitMQ;
$rabbit = new RabbitMQ();
$queue = 'test-single-queue';
$callback = function ($msg) {
    var_dump("Received Message: " . $msg->body);
    sleep(2);
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};
$rabbit->consumeMessage($queue, $callback);
unset($rabbit);*/


// 多个独立消费者
/*require_once "./vendor/autoload.php";
require_once "./RabbitMQ.php";
use RabbitMQ\RabbitMQ;
$rabbit = new RabbitMQ();
$exchangeName = 'test-ex-topic';
$queueName    = 'test-consumer-ex-topic';
$routingKey   = 'test.ex.*';//消费规则定义
//创建队列
$rabbit->createQueue($queueName, false, true);
//绑定到交换机
$rabbit->bindQueue($queueName, $exchangeName, $routingKey);
//消费
$callback = function ($message) {
    var_dump("Received Message : " . $message->body);//print message
    sleep(2);//处理耗时任务
    $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);//ack
};
$rabbit->consumeMessage($queueName, $callback);*/


// 延时队列
require_once './vendor/autoload.php';
require_once './DelayQueue.php';
// 消费者
$delay = new \RabbitMQ\DelayQueue();
$delayQueueName = 'delay-order-queue';
$callback = function ($msg) {
    echo $msg->body . PHP_EOL;
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);

    //处理订单超时逻辑，给用户推送提醒等等。。。
    sleep(10);
};
/**
 * 消费已经超时的订单信息，进行处理
 */
$delay->consumeMessage($delayQueueName, $callback);



