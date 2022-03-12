<?php

namespace Zhulong\Lib;

require 'vendor/autoload.php';


class PluginManager {
    /**
     * 监听已注册的插件
     *
     * @access private
     * @var array
     */
    private $_listeners = array();

    /**
     * 构造函数
     *
     * @access public
     * @return void
     */
    public function __construct() {
        foreach (glob(__DIR__ . "/actions/*.php") as $filename) {
            include_once($filename);
            $class = basename($filename, ".php");
            new $class($this);
        }
        #此处做些日志记录方面的东西
    }

    /**
     * 注册需要监听的插件方法（钩子）
     *
     * @param string $hook
     * @param object $reference
     * @param string $method
     */
    function register($hook, &$reference, $method) {
        //获取插件要实现的方法
        $key = get_class($reference);
        //将插件的引用连同方法push进监听数组中
        $this->_listeners[$hook][$key] = array(&$reference, $method);
        #此处做些日志记录方面的东西
    }

    /**
     * 触发一个钩子
     *
     * @param string $hook 钩子的名称
     * @param mixed $data 钩子的入参
     * @return mixed
     */
    function trigger($hook, $data = '') {
        $result = '';
        //查看要实现的钩子，是否在监听数组之中
        if (isset($this->_listeners[$hook]) && is_array($this->_listeners[$hook]) && count($this->_listeners[$hook]) > 0) {
            // 循环调用开始
            foreach ($this->_listeners[$hook] as $listener) {
                // 取出插件对象的引用和方法
                $class  =& $listener[0];
                $method = $listener[1];
                if (method_exists($class, $method)) {
                    // 动态调用插件的方法
                    $result .= $class->$method($data);
                }
            }
        }
        #此处做些日志记录方面的东西
        return $result;
    }
}