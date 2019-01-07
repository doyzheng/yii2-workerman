<?php

namespace doyzheng\yii2workerman;

/**
 * 事件
 * Class Event
 * @package doyzheng\yii2workerman
 */
class Event
{
    
    /**
     * @var array 配置
     */
    public static $config = [];
    
    /**
     * @param array $config
     */
    public static function init($config = [])
    {
        static::$config = $config;
    }
    
    /**
     * 消息事件处理
     * @param string $messageDir
     * @param string $clientId
     * @param string $message
     */
    public static function onMessage($messageDir, $clientId, $message)
    {
        // 客户端传递的是json数据
        $messageData = json_decode($message, true);
        if (!$messageData) {
            return;
        }
        if (empty($messageData['type'])) {
            return;
        }
        @list($class, $action) = explode('/', $messageData['type']);
        $className = ucfirst($class) . 'Message';// 消息处理类名
        $action    = $action ? $action : 'index';// 由那个方法处理
        $classFile = $messageDir . '/' . $className . '.php';// 类文件名
        if (is_file($classFile)) {
            include_once $classFile;
            if (class_exists($className)) {
                $class = new $className(static::$config);
                if ($class instanceof \doyzheng\yii2workerman\BaseMessage) {
                    if ($class && method_exists($class, $action)) {
                        call_user_func_array([$class, $action], [$clientId, $message]);
                    }
                }
            }
        }
    }
    
}
