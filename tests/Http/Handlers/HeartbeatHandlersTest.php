<?php

namespace Tests;

use Nimbly\Capsule\ResponseStatus;
use Tests\Http\HttpTestCase;

/**
 * @covers App\Http\Handlers\HeartbeatHandler
 */
class HeartbeatHandlersTest extends HttpTestCase
{
	public function test_get_endpoint(): void
	{
		$response = $this->makeRequest("get", "/heartbeat?q=foo");

		$this->assertEquals(
			ResponseStatus::OK->value,
			$response->getStatusCode()
		);

		$this->assertEquals(
			"{\"status\":\"Ok\"}",
			$response->getBody()->getContents()
		);
	}
}