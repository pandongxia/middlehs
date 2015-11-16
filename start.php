<?php
/**
 * run with command 
 * php start.php start
 */
ini_set('display_errors', 'on');
use Workerman\Worker;
define('GLOBAL_START', 1);
require_once __DIR__ . '/Workerman/Autoloader.php';
foreach(glob(__DIR__.'/Applications/Sender/start*') as $start_file)
{
    require_once $start_file;
}
Worker::runAll();