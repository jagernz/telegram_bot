<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$request = file_get_contents('php://input');
$request = json_decode( $request, TRUE );

$log = new Logger('REQUEST_INFO');
$log->pushHandler(new StreamHandler('app.log', Logger::DEBUG));

$log->addDebug(json_encode($request));