<?php

return [
	/**
	 * Adapter to use for the consumer.
	 *
	 * Options are:
	 * 	azure, beanstalkd, google, ironmq, mock, rabbitmq, redis_queue, sqs
	 */
	"adapter" => \getenv("CONSUMER_ADAPTER"),

	/**
	 * The message deadletter configuration.
	 */
	"deadletter" => [
		/**
		 * Adapter to use for the deadletter - options are identical to above.
		 */
		"adapter" => \getenv("CONSUMER_DEADLETTER_ADAPTER"),

		/**
		 * The topic or queue name/URL to publish deadletter messages to.
		 */
		"topic" => \getenv("CONSUMER_DEADLETTER_TOPIC"),
	],

	/**
	 * Interrupt signals you would like to cause a graceful shutdown process.
	 */
	"signals" => [SIGHUP, SIGINT, SIGTERM],

	/**
	 * Some consumers use a host setting.
	 */
	"host" => \getenv("CONSUMER_HOST"),

	/**
	 * Some consumers use a port number.
	 */
	"port" => \getenv("CONSUMER_PORT"),

	/**
	 * The topic or queue name/URL to listen to.
	 */
	"topic" => \getenv("CONSUMER_TOPIC"),

	/**
	 * Additional settings for IronMQ
	 */
	"ironmq" => [
		"token" => \getenv("IRONMQ_TOKEN"),
		"project_id" => \getenv("IRONMQ_PROJECT_ID"),
		"protocol" => \getenv("IRONMQ_PROTOCOL"),
		"api_version" => \getenv("IRONMQ_API_VERSION"),
		"encryption_key" => \getenv("IRONMQ_ENCRYPTION_KEY"),
	],

	/**
	 * Additional settings for RabbitMQ
	 */
	"rabbitmq" => [
		"user" => \getenv("RABBITMQ_USERNAME"),
		"password" => \getenv("RABBITMQ_PASSWORD"),
		"keepalive" => \getenv("RABBITMQ_KEEPALIVE"),
	],

	/**
	 * Additional settings for Redis
	 */
	"redis" => [
		"read_write_timeout" => 0,
	],

	/**
	 * Additional settings for SQS
	 */
	"sqs" => [
		"region" => \getenv("SQS_REGION"),
		"version" => \getenv("SQS_VERSION"),
	],

	/**
	 * Routes for consumed messages.
	 */
	"routes" => [
		"UserCreated" => "App\\Http\\Consumer\\Handlers\\UsersHandler@onUserCreated"
	],

	/**
	 * Providers for consumer
	 */
	"providers" => [
		Nimbly\Foundation\Consumer\Providers\ApplicationProvider::class,
	]
];