<?php

return [
	/**
	 * Adapter to use for the publisher.
	 *
	 * Options are:
	 * 	azure, beanstalkd, google, ironmq, mock, mqtt, rabbitmq, redis, redis_pubsub, sns, sqs
	 */
	"adapter" => \env("PUBLISHER_ADAPTER"),

	/**
	 * Some publishers use a host setting.
	 */
	"host" => \env("PUBLISHER_HOST"),

	/**
	 * Some publishers use a port number.
	 */
	"port" => \env("PUBLISHER_PORT"),

	/**
	 * Additional settings for SNS.
	 */
	"sns" => [
		"region" => \env("SNS_REGION"),
		"version" => \env("SNS_VERSION"),
	],

	/**
	 * Additional settings for SQS.
	 */
	"sns" => [
		"region" => \env("SQS_REGION"),
		"version" => \env("SQS_VERSION"),
	],

	/**
	 * Additional settings for Azure.
	 *
	 * `connection_string` is required to connect to Azure.
	 */
	"azure" => [
		"connection_string" => \env("AZURE_CONNECTION_STRING"),
	],

	/**
	 * Additional settings for IronMQ.
	 *
	 * `token` and `project_id` are required in order to connect to IronMQ.
	 */
	"ironmq" => [
		"token" => \env("IRONMQ_TOKEN"),
		"project_id" => \env("IRONMQ_PROJECT_ID"),
		"protocol" => \env("IRONMQ_PROTOCOL"),
		"api_version" => \env("IRONMQ_API_VERSION"),
		"encryption_key" => \env("IRONMQ_ENCRYPTION_KEY"),
	],

	/**
	 * Additional settings for RabbitMQ.
	 */
	"rabbitmq" => [
		"username" => \env("RABBITMQ_USERNAME"),
		"password" => \env("RABBITMQ_PASSWORD"),
		"keepalive" => \env("RABBITMQ_KEEPALIVE"),
	],

	/**
	 * Additional settings for MQTT.
	 *
	 * These settings are optional and not required.
	 */
	"mqtt" => [
		"client_id" => \env("MQTT_CLIENT_ID"),
		"protocol" => \env("MQTT_PROTOCOL"),
	]
];