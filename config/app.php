<?php

return [
	/**
	 * The name of your application or service.
	 */
	"name" => "MyApplication",

	/**
	 * The version of your application or service.
	 *
	 * If a file named VERSION exists in the root of your application,
	 * its contents will be used for this configuration value.
	 *
	 * Default is the ENV environment variable or "unknown" if no
	 * ENV environment variable is set.
	 */
	"version" => \file_exists(APP_ROOT . "/VERSION") ?
		\file_get_contents(APP_ROOT . "/VERSION") :
		\env("ENV", "unknown"),

	/**
	 * Default timezone to run application in. All date related PHP functions, logging, and
	 * database interactions will use this timezone.
	 *
	 * Can be changed via the TIMEZONE environment variable. Defaults to "UTC."
	 *
	 * @see https://www.php.net/manual/en/timezones.php
	 */
	"timezone" => \env("TIMEZONE", "UTC"),

	/**
	 * Enable or disable debug mode for the application.
	 *
	 * CAUTION:
	 * Debug mode will include extra logging information as well as additional information
	 * in HTTP error responses - including a full stack trace. Due to the sensitive nature of
	 * enabling debug mode, you SHOULD NOT enable this for production environments.
	 */
	"debug" => \env("DEBUG", false, "bool"),

	/**
	 * Global service providers to register into the dependency container.
	 *
	 * These providers can be a class reference or a fully instantiated instance
	 * of a service provider.
	 *
	 * These providers must implement Nimbly\Carton\ServiceProviderInterface.
	 *
	 * Feel free to disable, comment out, write your own version, or add to
	 * this list of providers.
	 */
	"providers" => [
		App\Core\Providers\DatabaseProvider::class,
		Nimbly\Foundation\Core\Providers\LoggerProvider::class,
		Nimbly\Foundation\Core\Providers\CacheProvider::class,
		Nimbly\Foundation\Core\Providers\FilesystemProvider::class,
		//Nimbly\Foundation\Core\Providers\DatabaseProvider::class,
		Nimbly\Foundation\Core\Providers\EventProvider::class,
		Nimbly\Foundation\Core\Providers\PublisherProvider::class,
	],

	/**
	 * Commands to register with the console.
	 */
	"commands" => [
		"setup" => Nimbly\Foundation\Commands\Setup::class,
		"jwt:hmac" => Nimbly\Foundation\Commands\JwtHmac::class,
		"jwt:keypair" => Nimbly\Foundation\Commands\JwtKeypair::class,
		"shell" => Nimbly\Foundation\Commands\Shell::class,
	]
];