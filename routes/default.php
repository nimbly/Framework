<?php

use Nimbly\Limber\Router\Router;

$router->group(
	namespace: "App\\Http\\Handlers",
	routes: function(Router $router): void {
		$router->get("/heartbeat", "HeartbeatHandler@get");
	}
);