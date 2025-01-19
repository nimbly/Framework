<?php

return [

	/**
	 * The adapter (or driver) to use for this connection.
	 *
	 * Options: "pgsql", "mysql", "sqlite", "sqlsrv", "oci", "memory"
	 */
	"adapter" => \env("DB_ADAPTER"),

	/**
	 * DSN connection string (optional.)
	 *
	 * If using a DSN connection string, you don't need to have values for host/port,
	 * username, password, database etc.
	 */
	"dsn" => \env("DB_DSN"),

	/**
	 * Host name of the database connection.
	 */
	"host" => \env("DB_HOST"),

	/**
	 * Port number to connect to.
	 *
	 * If null or empty string, the database's default port number will be used.
	 */
	"port" => \env("DB_PORT"),

	/**
	 * Instead of a host name, you can connect via socket.
	 */
	"socket" => \env("DB_SOCKET"),

	/**
	 * User name for connection.
	 */
	"username" => \env("DB_USERNAME"),

	/**
	 * Password for connection.
	 */
	"password" => \env("DB_PASSWORD"),

	/**
	 * Database name to connect to.
	 */
	"database" => \env("DB_DATABASE"),
];