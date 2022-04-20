<?php

namespace Core\Validation\Inputs;

/**
 * The class that represents a form input.
 */
abstract class Input
{
	/**
	 * @var string The input's name.
	 */
	private string $name;

	/**
	 * Initializes a new instance of the Input class.
	 *
	 * @param string $name The input's name.
	 */
	public function __construct(string $name)
	{
		$this->name = $name;
	}

	/**
	 * Validates the input.
	 *
	 * @return string An error message if invalid, empty string if valid.
	 */
	public abstract function validateInput(): string;

	/**
	 * Formats a validation error message.
	 *
	 * @param string $msg The message to format.
	 * @return string The formatted error message.
	 */
	protected function formatError(string $msg): string
	{
		return "$this->name: $msg";
	}
}
