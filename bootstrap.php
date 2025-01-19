<?php

use Dotenv\Dotenv;
use Nimbly\Caboodle\Config;
use Nimbly\Caboodle\Loaders\FileLoader;
use Nimbly\Carton\Container;
use Nimbly\Foundation\Core\Cache;
use Nimbly\Foundation\Core\Log;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

\defined("APP_ROOT") or \define("APP_ROOT", __DIR__);

require_once APP_ROOT . "/vendor/autoload.php";

/**
 * Load .env file if present.
 */
Dotenv::createUnsafeImmutable(APP_ROOT)->safeLoad();

/**
 * Create configuration manager.
 */
$config = new Config([
	new FileLoader(APP_ROOT . "/config")
]);

/**
 * Set default timezone.
 */
\date_default_timezone_set($config->get("app.timezone"));

/**
 * Set default error reporting level.
 */
\error_reporting(E_ALL);

/**
 * Create default container instance and load global providers.
 */
$container = Container::getInstance();
$container->set(Config::class, $config);
$container->register($config->get("app.providers"));

/**
 * Initialize the global logger class.
 */
Log::init($container->get(LoggerInterface::class));

/**
 * Initialize the global cache class.
 */
Cache::init($container->get(CacheItemPoolInterface::class));

return $container;