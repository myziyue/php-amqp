<?php
/**
 * Created by PhpStorm.
 *
 * @author Bi Zhiming <evan2884@gmail.com>
 * @created 2017/12/15  上午11:30
 * @since 1.0
 */

namespace myziyue\amqp;

class ZyProducer extends Base
{

    protected static $exchange = null;

    protected static $producer = null;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (static::$producer == null) {
            static::$producer = new self();
        }
        return static::$producer;
    }

    public function create()
    {
        try {
            $this->getChannel();
            static::$exchange = new \AMQPExchange(static::$channel);
            static::$exchange->setName($this->exchangeName);
            static::$exchange->setType($this->exchangeType);
            static::$exchange->setFlags($this->flags);
            static::$exchange->declareExchange();

            static::$queue = new \AMQPQueue(static::$channel);
            static::$queue->setName($this->queueName);
            static::$queue->setFlags($this->flags);
            static::$queue->declareQueue();
        } catch (\AMQPException $ex) {
            throw new \Exception($ex->getMessage());
            return false;
        }
        return true;
    }

    public function push($message, $key)
    {
        try {
            static::$channel->startTransaction();
            //echo "exchange status:".$ex->declare();
            echo "exchange status:" . static::$exchange->declareExchange();
            echo "\n";
            static::$exchange->publish($message, $key);
            static::$channel->commitTransaction();
        } catch (\AMQPException $ex) {
            throw new \Exception($ex);
            return false;
        }
        return true;
    }
}