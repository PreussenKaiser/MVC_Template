<?php

namespace Core\Validation;

use Core\Validation\Inputs\Input;

/**
 * The class that contains validation helper methods.
 * 
 * @author PreussenKaiser
 */
final class Form
{
	/**
	 * The inputs in the form.
	 * @var array
	 */
	private array $inputs;

	/**
	 * Starts creating validation for the form.
	 */
	public function __construct()
	{
		$this->inputs = [];
	}

	/**
	 * Builds a new form.
	 *
	 * @return $this The newly initialized form.
	 */
	public function buildForm(): self
	{
		return new self();
	}

	/**
	 * Adds an input to the validator.
	 *
	 * @param Input $input The input to validate.
	 * @return $this An instance of the validator with the added input.
	 */
	public function addInput(Input $input): self
	{
		array_push($this->inputs, $input);

		return $this;
	}

	/**
	 * Validates the form.
	 *
	 * @return string An error message if invalid, empty string if valid.
	 */
	public function validateForm(): string
	{
		$msg = '';

		foreach ($this->inputs as $input) {
			if ($input instanceof Input) {
				if (!empty($msg = $input->validateInput()))
					return $msg;
			}
		}

		return $msg;
	}
}