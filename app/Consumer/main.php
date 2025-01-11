<?php

use Nimbly\Foundation\Core\Log;
use Nimbly\Syndicate\Application;

$container = require __DIR__ . "/../../bootstrap.php";

Log::info("• Registering Queue providers");
$container->register(\config("queue.providers"));

Log::info("• Starting consumer");

/**
 * @var Application $application
 */
$application = $container->get(Application::class);
$application->listen(\config("consumer.topic"));