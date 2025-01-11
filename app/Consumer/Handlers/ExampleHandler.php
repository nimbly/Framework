<?php

namespace App\Consumer\Handlers;

use Nimbly\Syndicate\Message;
use Nimbly\Syndicate\Response;

class ExampleHandler
{
	/**
	 * @param Message $message
	 * @return void
	 */
	public function onUserRegistered(Message $message): Response
	{
		$payload = \json_decode($message->getPayload());

		if( \json_last_error() !== JSON_ERROR_NONE ){
			return Response::deadletter;
		}

		// Do something with message...


		return Response::ack;
	}
}