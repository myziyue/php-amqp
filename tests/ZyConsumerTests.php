<?php
/**
 * Created by PhpStorm.
 *
 * @author Bi Zhiming <evan2884@gmail.com>
 * @created 2017/12/15  上午11:40
 * @since 1.0
 */
include "../Base.php";
include "../ZyConsumer.php";


$bindingkey='key2';
$zyAmqp = \myziyue\amqp\ZyConsumer::getInstance();
$zyAmqp->setHost('192.168.30.11');
$zyAmqp->setVhost('/com.myziyue.mq');
$zyAmqp->setLogin('myziyue');
$zyAmqp->setPassword('12345678');
$zyAmqp->setExchangeName('exchange_demo');
$zyAmqp->setQueueName('queue_demo');
$zyAmqp->create($bindingkey);

while($message = $zyAmqp->popAll()){
    var_dump($message);
}


