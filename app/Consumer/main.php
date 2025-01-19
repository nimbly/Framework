<?php

use Nimbly\Carton\Container;
use Nimbly\Foundation\Core\Log;
use Nimbly\Syndicate\Application;

/**
 * @var Container $container
 */
$container = require __DIR__ . "/../../bootstrap.php";

Log::info("• Registering consumer providers");
$container->register(\config("consumer.providers"));

/**
 * @var Application $application
 */
$application = $container->get(Application::class);

Log::info("• Starting consumer");
$application->listen(\config("consumer.topic"));