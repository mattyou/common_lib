<?php

use Zhulong\Lib\PluginManager;
use GatewayClient\Gateway;
require_once("vendor/autoload.php");


$pluginManager = new PluginManager();
$pluginManager->trigger("demo1","gatewayClient");


