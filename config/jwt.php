<?php

return [

	/**
	 * The signing method.
	 *
	 * Options: "keypair", "hmac"
	 *
	 * KEYPAIR:
	 *
	 * If using "keypair", an asymmetric key (private and public key) are required. The keys contents
	 * must be base64 encoded and made available via the environment variables:
	 *
	 * JWT_PUBLIC_KEY
	 * JWT_PRIVATE_KEY
	 *
	 * The private key is only required if you will be issuing JWTs. The public key is only required
	 * if you will be accepting JWTs. You will need both if this service is issuing *and* accepting the
	 * JWT.
	 *
	 * HMAC:
	 *
	 * If using "hmac", the shared secret must be base64 encoded and made available via the
	 * environment variable:
	 *
	 * JWT_HMAC_SECRET
	 */
	"signer" => \getenv("JWT_SIGNER"),

	/**
	 * The signing algorithm to use.
	 *
	 * Options: "SHA256", "SHA384" "SHA512"
	 */
	"algorithm" => "SHA256",

	/**
	 * The issuer of the token, used as the `iss` claim.
	 *
	 * If null or empty string, defaults to the name of app (located in config/app.php),
	 * but you can override it here.
	 */
	"issuer" => null,

	/**
	 * The amount of time in seconds to account for drift when determining
	 * whether a token is expired (exp) or is ready to be accepted (nbf.)
	 *
	 * This is only used when verifying an incoming JWT.
	 *
	 * Defaults to 0.
	 */
	"leeway" => 0,

	/**
	 * The location of the JWT in the server request headers.
	 */
	"header" => [
		/**
		 * The request header name where the JWT can be found.
		 */
		"name" => "Authorization",

		/**
		 * The authorization scheme.
		 *
		 * For custom headers that do not use a scheme, you can set this value to an empty string or null.
		 */
		"scheme" => "Bearer"
	],

	/**
	 * An array of key value pairs mapping a key ID (string) to a Nimbly\Proof\SignerInterface instance.
	 *
	 * This key map can be used to support multiple different signing keys at once.
	 *
	 * Example:
	 *
	 * "keymap" => [
	 * 		"aetoT8Ae" => new HmacSigner(Proof::ALGO_SHA284, getenv(base64_decode("JWT_HMAC_SECRET"))),
	 * 		"eiPo0iGe" => new HmacSigner(Proof::ALGO_SHA384, getenv(base64_decode("DEPRECATED_JWT_HMAC_SECRET"))),
	 * ]
	 */
	"keymap" => [

	]
];