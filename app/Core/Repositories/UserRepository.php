<?php

namespace App\Core\Repositories;

use App\Core\Entities\User;
use App\Core\Events\UserRegisteredEvent;

class UserRepository extends RepositoryAbstract
{
	/**
	 * Create a new User.
	 *
	 * @param User $user
	 * @return boolean
	 */
	public function create(User $user): bool
	{
		$this->databaseManager->insert($user);
		$this->dispatcher->dispatch(new UserRegisteredEvent($user));
	}
}