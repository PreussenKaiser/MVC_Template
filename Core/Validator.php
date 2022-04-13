<?php
namespace Core;

use DateTime;
use Exception;

/**
 * The class that contains validation helper methods.
 */
class Validator
{
	/**
	 * Validates a form with provided inputs and parameters.
	 *
	 * Max values should be 'mapped' to their inputs in post.<br>
	 * (There's probably a better way to do this.)
	 *
	 * @param array $post The post from the form.
	 * @param array $max_values The maximum values for the inputs.
	 * @return string An error message if an input was invalid
	 */
	public function validateForm(array $post, array $max_values): string
	{
		unset($post['submit']);

		$input_names = array_keys($post);
		$input_values = array_values($post);
		$msg = '';

		for ($i = 0; $i < count($input_names); $i++)
		{
			$msg = $this->validateInput($input_values[$i], $input_names[$i], $max_values[$i]);

			if (!empty($msg))
				break;
		}

		return $msg;
	}

	/**
	 * Determines if the provided birthdate is valid.
	 *
	 * @param string $date The date to validate.
	 * @return string An error message if the date is invalid.
	 */
	public function validateBirthdate(string $date): string
	{
		try
		{
			$msg = new DateTime() < new DateTime($date) ?
				   'Please enter a past date' : '';
		}
		catch(Exception)
		{
			$msg = 'Could not read date';
		}

		return $msg;
	}

	/**
	 * Validates an input and outputs a corresponding message.
	 *
	 * @param mixed $value The input value to validate.
	 * @param string $name The name of the input.
	 * @param int $max_value The maximum length for the input.
	 * @return string A message if there was an error, none if the input was valid.
	 */
	private function validateInput(mixed $value, string $name, int $max_value): string
	{
		$name = ucfirst($name);
		$msg = '';

		if (empty($value))
			$msg = "$name must not be empty";
		else if (strlen($value) > $max_value)
			$msg = "$name must be $max_value characters long";
		else if (is_numeric($value) && $value > $max_value)
			$msg = "$name cannot exceed $max_value";

		return $msg;
	}
}