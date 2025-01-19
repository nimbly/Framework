<?php

use Monolog\Level;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;

return [

	/**
	 * Enable or disable logging.
	 *
	 * Disabling logging will use the NoopHandler.
	 */
	"enabled" => \env("LOG_ENABLED", true, "bool"),

	/**
	 * If logging is enabled, all Monolog handlers you would like to add.
	 *
	 * @see https://github.com/Seldaek/monolog/blob/main/doc/02-handlers-formatters-processors.md
	 */
	"handlers" => [

		/**
		 * error_log() handler.
		 */
		new ErrorLogHandler(
			messageType: ErrorLogHandler::OPERATING_SYSTEM,
			level: Level::fromName(\env("DEBUG", false, "bool") ? "debug": \env("LOG_LEVEL", "debug"))
		),

		/**
		 * Log handler to stream output to a single file.
		 */
		// new StreamHandler(
		//  	stream: \getenv("LOG_PATH"),
		//  	level: Level::fromName(\env("DEBUG", false, "bool") ? "debug": \env("LOG_LEVEL", "debug"))
		// ),

		/**
		 * Log handler to stream output to a daily rotated file.
		 */
		// new RotatingFileHandler(
		// 	filename: \getenv("LOG_PATH"),
		// 	maxFiles: 7,
		// 	level: level: Level::fromName(\env("DEBUG", false, "bool") ? "debug": \env("LOG_LEVEL", "debug"))
		// ),
	]
];