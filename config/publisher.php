<?php

return [
	/**
	 * Adapter to use for the publisher.
	 *
	 * Options are:
	 * 	azure, beanstalkd, google, ironmq, mock, mqtt, rabbitmq, redis_queue, redis_pubsub, sns, sqs
	 */
	"adapter" => \getenv("PUBLISHER_ADAPTER"),

	/**
	 * Some publishers use a host setting.
	 */
	"host" => \getenv("PUBLISHER_HOST"),

	/**
	 * Some publishers use a port number.
	 */
	"port" => \getenv("PUBLISHER_PORT"),

	/**
	 * Additional settings for SNS.
	 */
	"sns" => [
		"region" => \getenv("SNS_REGION"),
		"version" => \getenv("SNS_VERSION"),
	],

	/**
	 * Additional settings for SQS.
	 */
	"sns" => [
		"region" => \getenv("SQS_REGION"),
		"version" => \getenv("SQS_VERSION"),
	],

	/**
	 * Additional settings for Azure.
	 *
	 * `connection_string` is required to connect to Azure.
	 */
	"azure" => [
		"connection_string" => \getenv("AZURE_CONNECTION_STRING"),
	],

	/**
	 * Additional settings for IronMQ.
	 *
	 * `token` and `project_id` are required in order to connect to IronMQ.
	 */
	"ironmq" => [
		"token" => \getenv("IRONMQ_TOKEN"),
		"project_id" => \getenv("IRONMQ_PROJECT_ID"),
		"protocol" => \getenv("IRONMQ_PROTOCOL"),
		"api_version" => \getenv("IRONMQ_API_VERSION"),
		"encryption_key" => \getenv("IRONMQ_ENCRYPTION_KEY"),
	],

	/**
	 * Additional settings for RabbitMQ.
	 */
	"rabbitmq" => [
		"username" => \getenv("RABBITMQ_USERNAME"),
		"password" => \getenv("RABBITMQ_PASSWORD"),
		"keepalive" => \getenv("RABBITMQ_KEEPALIVE"),
	],

	/**
	 * Additional settings for MQTT.
	 *
	 * These settings are optional and not required.
	 */
	"mqtt" => [
		"client_id" => \getenv("MQTT_CLIENT_ID"),
		"protocol" => \getenv("MQTT_PROTOCOL"),
	]
];