<?php

namespace App\Core\Subscribers;

use Nimbly\Announce\Subscribe;
use App\Core\Events\UserRegisteredEvent;

class UserSubscriber
{
	#[Subscribe(UserRegisteredEvent::class)]
	public function onUserRegistered(UserRegisteredEvent $event): void
	{
		\error_log("Received UserRegisteredEvent: " . $event->getUser()->getId());
	}
}