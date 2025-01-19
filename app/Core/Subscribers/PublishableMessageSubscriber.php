<?php

namespace App\Core\Subscribers;

use Nimbly\Announce\Subscribe;
use Nimbly\Syndicate\PublisherInterface;
use Nimbly\Foundation\Core\PublishableMessageInterface;

/**
 * This subscriber listens to *all* locally triggered events and
 * publishes them to an external broker if the event implements
 * the `PublishableMessageInterface`.
 *
 * A common use case is that internally triggered events often have
 * value outside of the service itself and should be published to a
 * broker, a queue, or pubsub topic.
 *
 * @see `config/publisher.php`
 * @see DOCUMENTATION.md
 */
class PublishableMessageSubscriber
{
	public function __construct(
		protected PublisherInterface $publisher,
	)
	{
	}

	#[Subscribe("*")]
	public function onEvent(PublishableMessageInterface $event): void
	{
		$this->publisher->publish($event->getPublishableMessage());
	}
}