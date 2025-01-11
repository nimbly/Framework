<?php

use Monolog\Level;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\RotatingFileHandler;

return [
	/**
	 * All Monolog handlers you would like to add.
	 *
	 * @see https://github.com/Seldaek/monolog/blob/main/doc/02-handlers-formatters-processors.md
	 */
	"handlers" => [

		/**
		 * error_log() handler.
		 */
		new ErrorLogHandler(
			messageType: ErrorLogHandler::OPERATING_SYSTEM,
			level: Level::fromName(\getenv("LOG_LEVEL") ?: "debug")
		),

		/**
		 * Log handler to stream output to a single file.
		 */
		// new StreamHandler(
		//  	stream: \getenv("LOG_PATH"),
		//  	level: Level::fromName(\getenv("LOG_LEVEL") ?: "debug")
		// ),

		/**
		 * Log handler to stream output to a daily rotated file.
		 */
		// new RotatingFileHandler(
		// 	filename: \getenv("LOG_PATH"),
		// 	maxFiles: 7,
		// 	level: Level::fromName(\getenv("LOG_LEVEL") ?: "debug")
		// ),
	]
];