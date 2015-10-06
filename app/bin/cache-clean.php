<?php
header('Content-Type: text/html; charset=utf-8');
define('APP_PORTAL','message');

try {

    require_once dirname(__DIR__).'/init.php';
    $app = $factoryApplication();

} catch( \Phalcon\Exception $e ) {
    echo "PhalconException: ", $e->getMessage();
    echo  $e->getTraceAsString();
    exit;
}

// clean cache
CacheBrg::flush();

