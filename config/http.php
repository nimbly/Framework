<?php

return [

	/**
	 * OpenAPI schema and validation options.
	 */
	"schema" => [

		/**
		 * Enable request and response validation against your schema.
		 *
		 * Alternatively, you can comment out or remove `Nimbly\Foundation\Http\Middleware\SchemaValidatorMiddleware::class`
		 * from the `middleware` configuration below and `Nimbly\Foundation\Http\Providers\SchemaValidatorProvider::class`
		 * from the `providers` configuration below.
		 */
		"enabled" => true,

		/**
		 * Your OpenAPI schema file.
		 */
		"file" => APP_ROOT . "/openapi.json",

		/**
		 * Schema caching options.
		 */
		"cache" => [
			/**
			 * Enable or disable schema cache.
			 */
			"enabled" => true,

			/**
			 * Cache key to use for schema.
			 */
			"key" => \config("app.name") . "/" . \config("app.version"),

			/**
			 * Schema cache TTL (in seconds.)
			 */
			"ttl" => 86400 // 24 hours
		]
	],

	/**
	 * HTTP server configurations.
	 *
	 * These configurations are only used when running as a standalone server
	 * using React/HTTP library.
	 */
	"server" => [
		/**
		 * The IP and port number to listen on.
		 *
		 * Can be set with the HTTP_LISTEN environment variable.
		 *
		 * Defaults to "0.0.0.0:8000"
		 */
		"listen" => \env("HTTP_LISTEN", "0.0.0.0:8000"),

		/**
		 * The maximum number of concurrent connections allowed.
		 *
		 * Defaults to 64.
		 */
		"max_connections" => \env("HTTP_MAX_CONNECTIONS", 64),

		/**
		 * The maximum request size in bytes.
		 *
		 * Defaults to 1MB.
		 */
		"max_request_size" => \env("HTTP_MAX_REQUEST_SIZE", 1048576),

		/**
		 * Interrupt signals that will initiate a graceful shutdown.
		 *
		 * Defaults to [SIGHUP, SIGINT, SIGTERM].
		 */
		"signals" => [SIGHUP, SIGINT, SIGTERM]
	],

	/**
	 * All route definition files.
	 *
	 * You can have as many files as you wish to organize your routes.
	 *
	 * Alternatively, you can register the Nimbly\Limber\Router::class in the container
	 * and that will be used instead of the routes listed below.
	 */
	"routes" => [
		APP_ROOT . "/routes/default.php",
	],

	/**
	 * The default error message to include in the error reponse.
	 *
	 * For security reasons, it's not a good idea to use the exception's message as the error message,
	 * so this message will be used instead when the HTTP response code >= 500 Internal Server Error.
	 *
	 * For other non-5xx level HTTP responses, the exception's message *will* be used.
	 *
	 * If debug mode is enabled (@see config/app.php), the exception's message will be
	 * included in the error reponse within the "debug" property.
	 */
	"default_error_message" => "There was an issue processing your request.",

	/**
	 * Global middleware to be applied to *all* incoming HTTP requests.
	 */
	"middleware" => [
		Nimbly\Foundation\Http\Middleware\RequestLoggerMiddleware::class,
		Nimbly\Foundation\Http\Middleware\JsonMiddleware::class,
		Nimbly\Foundation\Http\Middleware\ValidateJwtMiddleware::class,
		Nimbly\Foundation\Http\Middleware\SchemaValidatorMiddleware::class,
		Nimbly\Foundation\Http\Middleware\ServerHeaderMiddleware::class,
	],

	/**
	 * HTTP specific service providers.
	 *
	 * These providers can be a class reference or a fully instantiated instance
	 * of a service provider.
	 *
	 * These providers must implement Nimbly\Carton\ServiceProviderInterface.
	 */
	"providers" => [
		Nimbly\Foundation\Http\Providers\SchemaValidatorProvider::class,
		Nimbly\Foundation\Http\Providers\JwtProvider::class,
		Nimbly\Foundation\Http\Providers\FrameworkProvider::class,
		Nimbly\Foundation\Http\Providers\HttpServerProvider::class,
	]
];