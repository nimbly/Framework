<?php

namespace App\Core\Services;

class ExampleService
{
	/**
	 * Send an email.
	 *
	 * @param string $email
	 * @param string $name
	 * @param string $template
	 * @return string|null
	 */
	public function send(string $email, string $name, string $template): ?string
	{
		if( $email === "fail@example.com" ){
			return null;
		}

		return "receipt";
	}
}