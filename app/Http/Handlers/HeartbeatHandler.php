<?php

namespace App\Http\Handlers;

use Nimbly\Capsule\ResponseStatus;
use Nimbly\Foundation\Http\JsonResponse;

class HeartbeatHandler
{
	/**
	 * Returns a simple 200 Ok response to indicate service is still up and running.
	 *
	 * This endpoint can be used with load balancers or other systems to detect service availability.
	 *
	 * @return JsonResponse
	 */
	public function get(): JsonResponse
	{
		return new JsonResponse(
			ResponseStatus::OK,
			["status" => "Ok"]
		);
	}
}