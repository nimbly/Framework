<?php

use Nimbly\Carton\Container;
use Nimbly\Foundation\Core\Log;
use React\Http\HttpServer;
use React\EventLoop\Loop;
use React\Socket\SocketServer;

/**
 * @var Container $container
 */
$container = require __DIR__ . "/../../bootstrap.php";

Log::info("• Registering HTTP providers...");
$container->register(\config("http.providers"));

Log::info("• Using " . \get_class(Loop::get()) . " event loop");

$listen = \config("http.server.listen") ?? "0.0.0.0:8000";
Log::info("• Listening on " . $listen);

/**
 * @var HttpServer $httpServer
 */
$httpServer = $container->get(HttpServer::class);
$httpServer->listen(new SocketServer($listen));