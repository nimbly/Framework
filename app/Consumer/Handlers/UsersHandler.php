<?php

namespace App\Consumer\Handlers;

use Exception;
use App\Core\Entities\User;
use Nimbly\Syndicate\Consume;
use Nimbly\Syndicate\Message;
use Nimbly\Syndicate\Response;
use App\Core\Services\ExampleService;

class UsersHandler
{
	/**
	 * @param Message $message
	 * @return Response
	 */
	#[Consume(
		topic: "users",
		payload: ["$.event" => "UserRegistered"],
	)]
	public function onUserRegistered(Message $message, ExampleService $exampleService): Response
	{
		try {

			$user = User::fromJson($message->getPayload());
		}
		catch( Exception ){
			return Response::deadletter;
		}

		$receipt = $exampleService->send(
			$user->getEmail(),
			$user->getName(),
			"templates/registration.tpl"
		);

		if( $receipt === null ){
			return Response::nack;
		}

		return Response::ack;
	}
}