<?php
/**
 * Created by PhpStorm.
 *
 * @author Bi Zhiming <evan2884@gmail.com>
 * @created 2017/12/15  上午11:30
 * @since 1.0
 */

namespace myziyue\amqp;

use myziyue\amqp\lib\Channel;
use myziyue\amqp\lib\Exchange;


class ZyConsumer extends Base
{
    protected static $consumer = null;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (static::$consumer == null) {
            static::$consumer = new self();
        }
        return static::$consumer;
    }

    public function create($bindKey)
    {
        try {
            $this->getChannel();

            static::$queue = new \AMQPQueue(static::$channel);
            static::$queue->setName($this->queueName);
            static::$queue->setFlags($this->flags);
            static::$queue->declareQueue();

            static::$queue->bind($this->exchangeName, $bindKey);
        } catch (\AMQPException $ex) {
            throw new \Exception($ex->getMessage());
            return false;
        }
        return true;
    }

    public function pop()
    {
        $message = static::$queue->get(AMQP_AUTOACK);
        return json_decode($message->getBody(), true);
    }

    public function popAll()
    {
        $rs = [];
        while ($message = static::$queue->get(AMQP_AUTOACK)) {
            $rs[] = json_decode($message->getBody(), true);
        }
        return $rs;
    }


}