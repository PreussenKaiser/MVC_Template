<?php

namespace Core\Validation\Inputs;

use DateTime;
use Exception;

/**
 * The class that represents a date picker input.
 */
final class DateInput extends Input
{
	/**
	 * @var DateTime The date to validate.
	 */
	private DateTime $date;

	/**
	 * Initializes a new instance of the DateInput class.
	 *
	 * @param string $name The input's name.
	 * @param string $date The date to validate.
	 */
	public function __construct(string $name, string $date)
	{
		parent::__construct($name);

		try {
			$this->date = new DateTime($date);
		}
		catch (Exception) {
			echo 'hello';
			$this->date = new DateTime('2222-03-24 00:00:00');
		}
	}

	/**
	 * Determines if the date is in the past.
	 *
	 * @return string An error message if invalid, empty string if valid.
	 */
	public function validateInput(): string
	{
		return $this->date < new DateTime()
			? ''
			: $this->formatError('Please enter a past date');
	}
}