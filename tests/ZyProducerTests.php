<?php
/**
 * Created by PhpStorm.
 *
 * @author Bi Zhiming <evan2884@gmail.com>
 * @created 2017/12/15  上午11:40
 * @since 1.0
 */
include "../Base.php";
include "../ZyProducer.php";

$zyAmqp = \myziyue\amqp\ZyProducer::getInstance();
$zyAmqp->setHost('192.168.30.11');
$zyAmqp->setVhost('/com.myziyue.mq');
$zyAmqp->setLogin('myziyue');
$zyAmqp->setPassword('12345678');
$zyAmqp->setExchangeName('exchange_demo');
$zyAmqp->setQueueName('queue_demo');
$zyAmqp->create();

$message = json_encode(array('Hello World3!', 'php3', 'c++3:'));
$routingkey = 'key2';

$zyAmqp->push($message, $routingkey);

