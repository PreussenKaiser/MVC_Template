<?php

namespace Core\Validation\Inputs;

use App\Models\Users;

final class UserInput extends Input
{
	/**
	 * @var string The username to search for.
	 */
	private string $username;

	/**
	 * @var string The password to search for.
	 */
	private string $password;

	/**
	 * @var Users The model to query users with.
	 */
	private Users $users;

	/**
	 * Initializes a new instance of the UserInput class,
	 * 
	 * @param string $username The username to validate.
	 * @param string $password The password to validate.
	 * @param Users $users The model to query users with.
	 */
	public function __construct(string $username, string $password,
								Users $users)
	{
		parent::__construct('Credentials');

		$this->username = $username;
		$this->password = sha1($password);
		$this->users = $users;
	}


	/**
	 * Determines if the username and password exist in the users model.
	 *
	 * @return string An error message if invalid, empty string if valid.
	 */
	public function validateInput(): string
	{
		return
			$this->users->isCorrectPassword(
				$this->username, $this->password
			)
			? ''
			: $this->formatError('Incorrect username or password');
	}
}