<?php

use Nimbly\Foundation\Core\Log;
use React\Http\HttpServer;
use React\EventLoop\Loop;
use React\Socket\SocketServer;

$container = require __DIR__ . "/../../bootstrap.php";

Log::info("• Registering HTTP providers with container");
$container->register(\config("http.providers"));

Log::info("• Using " . \get_class(Loop::get()) . " event loop");

$listen = \config("http.server.listen") ?? "0.0.0.0:8000";

Log::info("• Listening on " . $listen);
$container->get(HttpServer::class)->listen(
	new SocketServer($listen)
);