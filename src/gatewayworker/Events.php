<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */

//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
use Zhulong\Lib\PluginManager;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events {
    private static $pm;

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id) {
        // 初始化钩子类
        self::$pm = new PluginManager();
        // 连接时间事件触发的业务逻辑，写到onconnect.php文件，一般处理初始化工作
        self::$pm->trigger("onconnect",$client_id);
    }

    /**
     * 当客户端发来消息时触发
     * 消息格式：
     * {
     *    "type": "", // "ping" "pong" "demo1"(actions目录中的文件名，不带后缀）
     *    "message":{} // 自定义json对象
     * }
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $message) {
        //解析json
        $data = json_decode($message,true);
        if ($data["type"] != "ping") {
            $data["client_id"] = $client_id;
            self::$pm->trigger($data["type"], $data);
        }
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id) {
        // 连接时间事件触发的业务逻辑，写到onclose.php文件，一般处理清理工作
        self::$pm->trigger("onclose",$client_id);
    }
}
