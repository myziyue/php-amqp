<?php
/**
 * Created by PhpStorm.
 *
 * @author Bi Zhiming <evan2884@gmail.com>
 * @created 2017/12/15  下午3:45
 * @since 1.0
 */

namespace myziyue\amqp;


class Base
{
    /**
     * @var string 连接地址
     */
    protected $host = 'localhost';
    /**
     * @var string 端口
     */
    protected $port = '5672';
    /**
     * @var string 账号
     */
    protected $login = 'guest';
    /**
     * @var string 密码
     */
    protected $password = 'guest';
    /**
     * @var string vhost
     */
    protected $vhost = '/';
    /**
     * @var int flags
     */
    protected $flags = AMQP_DURABLE;
    /**
     * @var string 交换机
     */
    protected $exchangeName = '';
    /**
     * @var string 交换协议
     */
    protected $exchangeType = AMQP_EX_TYPE_DIRECT;

    /**
     * @var string 队列名称
     */
    protected $queueName = '';

    protected static $exchange = null;
    protected static $queue = null;

    protected static $channel = null;


    public function __construct()
    {
        if(extension_loaded('amqp') == false){
            throw new \Exception('Failed to create AMQPConnection object; amqp extension not loaded?');
            return false;
        }
    }

    public function getChannel(){
        $config = [
            'host' => $this->host,
            'port' => $this->port,
            'login' => $this->login,
            'password' => $this->password,
            'vhost'=> $this->vhost
        ];
        $connection = new \AMQPConnection($config);
        if (!$connection->connect()) {
            throw new \Exception("Cannot connect to the broker!");
        }
        static::$channel = new \AMQPChannel($connection);
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @param string $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $vhost
     */
    public function setVhost($vhost)
    {
        $this->vhost = $vhost;
    }

    /**
     * @param int $flags
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;
    }

    /**
     * @param string $exchangeName
     */
    public function setExchangeName($exchangeName)
    {
        $this->exchangeName = $exchangeName;
    }

    /**
     * @param string $exchangeType
     */
    public function setExchangeType($exchangeType)
    {
        $this->exchangeType = $exchangeType;
    }


    /**
     * @param string $queueName
     */
    public function setQueueName($queueName)
    {
        $this->queueName = $queueName;
    }
}