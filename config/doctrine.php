<?php

return [

	/**
	 * Paths of entities.
	 */
	"entities" => [
		APP_ROOT . "/app/Core/Entities",
	],

	/**
	 * Custom data types to add to Doctrine.
	 */
	"types" => [
		"uuid" => Ramsey\Uuid\Doctrine\UuidType::class,
	]
];