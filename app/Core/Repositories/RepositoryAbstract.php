<?php

namespace App\Core\Repositories;

use Psr\EventDispatcher\EventDispatcherInterface;

abstract class RepositoryAbstract
{
	public function __construct(
		protected DatabaseManager $databaseManager,
		protected EventDispatcherInterface $dispatcher,
	)
	{
	}

	abstract public function create(mixed $entity);

	public function find(mixed $id): static
	{
		return $this->db->find($id);
	}

	public function update(mixed $entity): static
	{

	}
}