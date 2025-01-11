<?php

return [

	/**
	 * Options:
	 *
	 * apcu, redis, memory, file, null, pdo
	 */
	"adapter" => \getenv("CACHE_ADAPTER") ?: "file",

	/**
	 * Connection or host string (used for redis and pdo).
	 */
	"connection" => \getenv("CACHE_CONNECTION") ?: null,

	/**
	 * For file based caching, the directory to write cache files to.
	 */
	"directory" => \realpath(\getenv("CACHE_DIRECTORY")) ?: APP_ROOT . "/storage/cache",

	/**
	 * Namespace for cache items.
	 */
	"namespace" => \getenv("CACHE_NAMESPACE"),

];