#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;

$container = require __DIR__ . "/bootstrap.php";
$container->register(\config("http.providers") ?? []);
$container->register(\config("consumer.providers") ?? []);
$container->register(\config("scheduler.providers") ?? []);

/**
 * Add commands to container.
 */
foreach( \config("app.commands") ?? [] as $command ){
	$container->set($command, $container->make($command));
}

$console = new Application(\config("app.name"), \config("app.version"));
$console->setCatchExceptions(true);
$console->setCatchErrors(true);
$console->setCommandLoader(
	new ContainerCommandLoader(
		$container,
		\config("app.commands") ?? []
	)
);

$console->run();