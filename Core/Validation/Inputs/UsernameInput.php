<?php

namespace Core\Validation\Inputs;

use App\Models\Users;

/**
 * The class that represents a username input.
 */
final class UsernameInput extends Input
{
	/**
	 * @var string The username to check against.
	 */
	private string $username;

	/**
	 * @var Users The model to query users with.
	 */
	private Users $users;

	/**
	 * Initializes a new instance of the UsernameInput class.
	 *
	 * @param string $name The name of the input.
	 * @param string $username The username to check against.
	 */
	public function __construct(string $name, string $username,
								Users $users)
	{
		parent::__construct($name);

		$this->username = $username;
		$this->users = $users;
	}

	/**
	 * Determines if the username hasn't been taken.
	 *
	 * @return string An error message if it was taken, empty string if it wasn't.
	 */
	public function validateInput(): string
	{
		return empty($this->users->getUsername($this->username))
			? ''
			: $this->formatError('Username has already been taken');
	}
}