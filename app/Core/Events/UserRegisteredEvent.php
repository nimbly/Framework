<?php

namespace App\Core\Events;

use Ramsey\Uuid\Uuid;
use App\Core\Entities\User;
use Nimbly\Syndicate\Message;
use Nimbly\Foundation\Core\PublishableMessageInterface;

class UserRegisteredEvent implements PublishableMessageInterface
{
	public function __construct(
		protected User $user,
	)
	{
	}

	/**
	 * Get the User entity instance for this event.
	 *
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}

	/**
	 * @inheritDoc
	 */
	public function getPublishableMessage(): Message
	{
		return new Message(
			"users",
			\json_encode([
				"id" => Uuid::uuid4()->toString(),
				"topic" => "users",
				"event" => "UserRegistered",
				"origin" => \config("app.name"),
				"published_at" => \date("c"),
				"body" => $this->user,
			])
		);
	}
}