<?php


/***************************************************************************
 *
 * Copyright (c) 2020 doushen.com, Inc. All Rights Reserved
 *
 **************************************************************************/


namespace RabbitMQ;
require_once './RabbitMQ.php';

use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

/**
 * 使用RabbitMQ实现延时队列功能
 * Class DelayQueue
 * @package RabbitMQ
 */
class DelayQueue extends RabbitMQ
{

    /**
     * 创建延时队列
     * @param $ttl
     * @param $delayExName
     * @param $delayQueueName
     * @param $queueName
     */
    public function createQueue2($ttl, $delayExName, $delayQueueName, $queueName)
    {
        $args = new AMQPTable([
            'x-dead-letter-exchange' => $delayExName,
            'x-message-ttl' => $ttl, //消息存活时间
            'x-dead-letter-routing-key' => $queueName
        ]);
        $this->channel->queue_declare($queueName, false, true, false, false, false, $args);
        //绑定死信queue
        $this->channel->exchange_declare($delayExName, AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_declare($delayQueueName, false, true, false, false);
        $this->channel->queue_bind($delayQueueName, $delayExName, $queueName, false);
    }
}
