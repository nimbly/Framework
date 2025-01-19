<?php

use Nimbly\Foundation\Core\Log;
use Nimbly\Syndicate\Response;

return [
	/**
	 * Consumer adapter to use.
	 *
	 * Options: azure, beanstalkd, google, ironmq, mock, rabbitmq, redis, sqs
	 */
	"adapter" => \env("CONSUMER_ADAPTER"),

	/**
	 * The message deadletter configuration.
	 */
	"deadletter" => [
		/**
		 * Adapter to use for the deadletter - options are identical to above.
		 */
		"adapter" => \env("CONSUMER_DEADLETTER_ADAPTER"),

		/**
		 * The topic or queue name/URL to publish deadletter messages to.
		 */
		"topic" => \env("CONSUMER_DEADLETTER_TOPIC"),
	],

	/**
	 * Interrupt signals you would like to cause a graceful shutdown process.
	 */
	"signals" => [SIGHUP, SIGINT, SIGTERM],

	/**
	 * Some consumers use a host setting.
	 */
	"host" => \env("CONSUMER_HOST"),

	/**
	 * Some consumers use a port number.
	 */
	"port" => \env("CONSUMER_PORT"),

	/**
	 * The topic or queue name/URL to listen to.
	 */
	"topic" => \env("CONSUMER_TOPIC"),

	/**
	 * Additional settings for IronMQ
	 */
	"ironmq" => [
		"token" => \env("IRONMQ_TOKEN"),
		"project_id" => \env("IRONMQ_PROJECT_ID"),
		"protocol" => \env("IRONMQ_PROTOCOL"),
		"api_version" => \env("IRONMQ_API_VERSION"),
		"encryption_key" => \env("IRONMQ_ENCRYPTION_KEY"),
	],

	/**
	 * Additional settings for RabbitMQ
	 */
	"rabbitmq" => [
		"user" => \env("RABBITMQ_USERNAME"),
		"password" => \env("RABBITMQ_PASSWORD"),
		"keepalive" => \env("RABBITMQ_KEEPALIVE"),
	],

	/**
	 * Additional settings for Redis
	 */
	"redis" => [
		"parameters" => [
			"read_write_timeout" => 0,
		],

		"options" => []
	],

	/**
	 * Additional settings for SQS
	 */
	"sqs" => [
		"region" => \env("SQS_REGION"),
		"version" => \env("SQS_VERSION"),
	],

	/**
	 * All consumer handler classes.
	 *
	 * These classes are assumed to have one or more public methods
	 * tagged with the #[Consume] attribute.
	 */
	"handlers" => [
		App\Consumer\Handlers\UsersHandler::class,
	],

	/**
	 * The default message handler if no route could be resolved.
	 */
	"default_handler" => function(): Response {
		Log::warning("Message could not be routed to consumer handler. Sending to deadletter.");
		return Response::deadletter;
	},

	/**
	 * Providers for consumer
	 */
	"providers" => [
		Nimbly\Foundation\Consumer\Providers\ApplicationProvider::class,
	]
];