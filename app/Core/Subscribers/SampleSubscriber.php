<?php

namespace App\Core\Subscribers;

use Nimbly\Announce\Subscribe;
use App\Core\Events\SampleEvent;

class SampleSubscriber
{
	#[Subscribe(SampleEvent::class)]
	public function onSampleEvent(SampleEvent $event): void
	{
		\error_log("Received SampleEvent: " . $event->getMessage());
	}
}