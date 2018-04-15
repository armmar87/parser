<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 30);

$GLOBALS['config'] = array(
    'mysql' =>array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db' => 'parser'
    ),
);

spl_autoload_register(function ($class){
    require_once 'classes/' . $class . '.php';
});
