<?php
namespace Zl\Lib;

use GatewayClient\Gateway;
require_once ("../vendor/autoload.php");


class Test{
    public static function test(){
        echo "hello World！";
    }
}

function SendToAll(){
    call_user_func(array("Zl\\Lib\\Test","test"));
}

SendToAll();
