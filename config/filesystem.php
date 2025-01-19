<?php

return [

	/**
	 * File system adapter to use.
	 *
	 * Options: local, memory, s3, sftp, ftp, azure, gcp
	 */
	"adapter" => \env("FILESYSTEM_ADAPTER", "local"),

	/**
	 * The base/root path (or bucket, or container, etc) for files to be
	 * stored and retrieved from.
	 */
	"path" => \env("FILESYSTEM_PATH"),

	/**
	 * Prefix all reads and writes to the file system with this path.
	 */
	"path_prefix" => \env("FILESYSTEM_PREFIX"),

	/**
	 * The file system should be read only - even if the access rights allow writes.
	 *
	 * Effectively this disables writes, enforced within code, not at the file system level.
	 */
	"read_only" => \env("FILESYSTEM_READONLY", false, "bool"),

	/**
	 * Options for remote filesystems (FTP & SFTP.)
	 */
	"remote" => [
		/**
		 * Hostname for remote server.
		 */
		"host" => \env("FILESYSTEM_REMOTE_HOST"),

		/**
		 * Port number for remote server.
		 *
		 * Leave empty/null for default port numbers (20 for FTP and 22 for SFTP.)
		 */
		"port" => \env("FILESYSTEM_REMOTE_PORT"),

		/**
		 * Username for remote server.
		 */
		"username" => \env("FILESYSTEM_REMOTE_USERNAME"),

		/**
		 * Password for remote server.
		 *
		 * If connecting via SFTP and using a private key, this should be null.
		 */
		"password" => \env("FILESYSTEM_REMOTE_PASSWORD"),

		/**
		 * Connection timeout in seconds.
		 *
		 * Defaults to 10.
		 */
		"timeout" => \env("FILESYSTEM_REMOTE_TIMEOUT", 10),

		/**
		 * FTP specific options.
		 */
		"ftp" => [
			/**
			 * Enable or disable SSL.
			 */
			"ssl" => \env("FILESYSTEM_REMOTE_FTP_SSL", false, "bool"),

			/**
			 * Enable or disable passive mode.
			 */
			"passive" => \env("FILESYSTEM_REMOTE_FTP_PASSIVE", true, "bool"),

			/**
			 * File transfer mode.
			 */
			"mode" => FTP_BINARY,
		],

		/**
		 * SFTP specific options.
		 */
		"sftp" => [
			/**
			 * The private key contents OR an absolute path and file name of private key.
			 *
			 * If using a private key, ensure the password option above is null.
			 */
			"private_key" => \env("FILESYSTEM_REMOTE_SSH_PRIVATE_KEY"),

			/**
			 * Passphrase for private key (if required.)
			 */
			"passphrase" => \env("FILESYSTEM_REMOTE_SSH_PRIVATE_KEY_PASSPHRASE"),

			/**
			 * Remote host fingerprint.
			 */
			"fingerprint" => \env("FILESYSTEM_REMOTE_SSH_FINGERPRINT")
		],
	],
];