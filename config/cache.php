<?php

return [

	/**
	 * Cache adapter to use.
	 *
	 * Options: redis, memory, file, pdo, apcu, memcache, null
	 */
	"adapter" => \env("CACHE_ADAPTER", "file"),

	/**
	 * The default TTL for cache items if none is provided when
	 * adding to the cache.
	 */
	"default_ttl" => 0,

	/**
	 * Connection or host string (used for redis and pdo).
	 */
	"connection" => \env("CACHE_CONNECTION"),

	/**
	 * For file based caching, the directory to write cache files to.
	 */
	"path" => \realpath(\env("CACHE_PATH", "storage/cache")),

	/**
	 * Namespace for cache items.
	 */
	"namespace" => \env("CACHE_NAMESPACE"),

	/**
	 * A custom marshaller for your cache items.
	 *
	 * This instance must implement `Symfony\Component\Cache\Marshaller\MarshallerInterface`.
	 * Optionally you may add your custom marshaller to the dependecy container, keyed as
	 * `Symfony\Component\Cache\Marshaller\MarshallerInterface`.
	 *
	 * Defaults to Symfony's `DefaultMarshaller`.
	 */
	"marshaller" => null,
];