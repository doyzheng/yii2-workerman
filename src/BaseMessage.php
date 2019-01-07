<?php

namespace doyzheng\yii2workerman;

use Workerman\MySQL\Connection;

/**
 * Class BaseController
 * @package Applications\controllers
 */
abstract class BaseMessage
{
    
    /**
     * @var Connection
     */
    public $db;
    
    /**
     * @var array 消息数据
     */
    private $_messageData;
    
    /**
     * @var int 客户端连接ID
     */
    public $clientId;
    
    /**
     * BaseController constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        foreach ($config as $name => $value) {
            if (property_exists($this, $name)) {
                $this->$name = $value;
            }
        }
    }
    
    /**
     * 获取全部参数
     * @return mixed|null
     */
    public function getParams()
    {
        return isset($this->_messageData['data']) ? $this->_messageData['data'] : '';
    }
    
    /**
     * @param $name
     * @return null
     */
    public function getParam($name)
    {
        $params = $this->getParams();
        return isset($params[$name]) ? $params[$name] : '';
    }
    
}
