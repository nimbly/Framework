<?php

namespace Tests\Consumer\Handlers;

use App\Consumer\Handlers\UsersHandler;
use App\Core\Services\ExampleService;
use Nimbly\Syndicate\Message;
use Nimbly\Syndicate\Response;
use Tests\Consumer\ConsumerTestCase;

/**
 * @covers App\Consumer\Handlers\UsersHandler
 */
class UsersHandlerTest extends ConsumerTestCase
{
	public function test_loading_user_from_json_failure_returns_deadletter(): void
	{
		$handler = new UsersHandler;
		$response = $handler->onUserRegistered(
			new Message("test", "foo"),
			new ExampleService
		);

		$this->assertEquals(
			Response::deadletter,
			$response
		);
	}

	public function test_send_failure_returns_nack(): void
	{
		$handler = new UsersHandler;
		$response = $handler->onUserRegistered(
			new Message(
				"test",
				\json_encode([
					"id" => "48e21b82-690d-494c-b6ff-02b25e1c0aca",
					"email" => "fail@example.com",
					"name" => "John Doe",
					"role" => "user"
				])
			),
			new ExampleService
		);

		$this->assertEquals(
			Response::nack,
			$response
		);
	}

	public function test_send_success_returns_ack(): void
	{
		$handler = new UsersHandler;
		$response = $handler->onUserRegistered(
			new Message(
				"test",
				\json_encode([
					"id" => "48e21b82-690d-494c-b6ff-02b25e1c0aca",
					"email" => "john@example.com",
					"name" => "John Doe",
					"role" => "user"
				])
			),
			new ExampleService
		);

		$this->assertEquals(
			Response::ack,
			$response
		);
	}
}