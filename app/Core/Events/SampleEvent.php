<?php

namespace App\Core\Events;

class SampleEvent
{
	public function __construct(
		protected string $message
	)
	{
	}

	public function getMessage(): string
	{
		return $this->message;
	}
}