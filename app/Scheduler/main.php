<?php

use Nimbly\Foundation\Core\Log;
use GO\Scheduler;
use Nimbly\Carton\Container;

/**
 * @var Container $container
 */
$container = require __DIR__ . "/../../bootstrap.php";

Log::info("• Registering scheduler providers");
$container->register(\config("scheduler.providers"));

Log::info("• Running scheduled tasks");
try {

	$container->get(Scheduler::class)->run(
		new DateTime($argv[1] ?? "now")
	);
}
catch( Throwable $exception ){
	Log::critical("Uncaught exception occured in handler: " . $exception->getMessage());
}
