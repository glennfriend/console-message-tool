<?php
header('Content-Type: text/html; charset=utf-8');
define('APP_PORTAL','admin');
require_once dirname(dirname(__FILE__)).'/init.php';

try {
    $app = $factoryApplication();
} catch( \Phalcon\Exception $e ) {
    echo "PhalconException: ", $e->getMessage();
    exit;
}

// clean cache
CacheBrg::flush();

