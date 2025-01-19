<?php

return [

	/**
	 * Local event subscriber classes.
	 *
	 * These classes will be registered with the local event dispatcher.
	 */
	"subscribers" => [
		App\Core\Subscribers\UserSubscriber::class,
		App\Core\Subscribers\PublishableMessageSubscriber::class,
	]
];