<?php

use Carton\Container;

/**
 * @var Container $container
 */
$container = require __DIR__ . "/../bootstrap.php";
$container->register(\config("http.providers"));
$container->register(\config("consumer.providers"));
$container->register(\config("scheduler.providers"));