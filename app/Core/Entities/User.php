<?php

namespace App\Core\Entities;

use TypeError;
use JsonSerializable;
use App\Core\Enums\UserRole;
use Doctrine\ORM\Mapping\Id;
use UnexpectedValueException;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\CustomIdGenerator;

#[Entity]
#[Table(name: "users")]
class User implements JsonSerializable
{
	public function __construct(
		#[Column(unique: true)]
		protected string $email,

		#[Column]
		protected string $name,

		#[Column(enumType: UserRole::class)]
		protected UserRole $role = UserRole::user,

		#[Id, Column(type: "uuid", unique: true)]
		#[GeneratedValue(strategy: "CUSTOM")]
    	#[CustomIdGenerator(class: UuidGenerator::class)]
		protected ?string $id = null,
	)
	{
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getRole(): UserRole
	{
		return $this->role;
	}

	/**
	 * Hydrate a User entity instance from JSON.
	 *
	 * @param string $json
	 * @throws TypeError
	 * @return User
	 */
	public static function fromJson(string $json): User
	{
		$payload = \json_decode($json);

		if( \json_last_error() !== JSON_ERROR_NONE ){
			throw new UnexpectedValueException("Contents do not appear to be valid JSON.");
		}

		return new self(
			$payload->email,
			$payload->name,
			$payload->role,
			$payload->id
		);
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize(): mixed
	{
		return [
			"id" => $this->id,
			"email" => $this->email,
			"name" => $this->name,
			"role" => $this->role->value,
		];
	}
}