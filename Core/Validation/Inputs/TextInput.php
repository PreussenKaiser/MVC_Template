<?php

namespace Core\Validation\Inputs;

/**
 * The class that represents a text input.
 */
final class TextInput extends Input
{
	/**
	 * @var string The input's value.
	 */
	private string $value;

	/**
	 * @var int The maximum length for the input.
	 */
	private int $max_length;

	/**
	 * Initializes a new instance of the TextInput class.
	 *
	 * @param string $name The name of the input.
	 * @param string $value The value of the input.
	 * @param int $max_length The maximum length for the input.
	 */
	public function __construct(string $name, string $value,
										int    $max_length)
	{
		parent::__construct($name);

		$this->value = $value;
		$this->max_length = $max_length;
	}


	/**
	 * Validation checks for
	 * - Value isn't empty.
	 * - Value length is less than or equal to max_length.
	 *
	 * @return string An error message of invalid, empty string if valid.
	 */
	public function validateInput(): string
	{
		$msg = '';

		if (empty($this->value)) {
			$msg = $this->formatError('Please enter a value');
		}
		else if (strlen($this->value) > $this->max_length) {
			$msg = $this->formatError(
				"Length should be less than or equal to
				$this->max_length characters long"
			);
		}

		return $msg;
	}
}