<?php

namespace Core\Tests;

use Core\Validation\Form;
use Core\Validation\Inputs\TextInput;

use PHPUnit\Framework\TestCase;

/**
 * The test for the form class.
 */
final class FormTest extends TestCase
{
	/**
	 * @var form The form to use for testing.
	 */
	private Form $form;

	/**
	 * Initializes a new instance of the FormTest test.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->form = new Form();
	}

	/**
	 * Tests a valid text input.
	 */
	public function testValidText(): void
	{
		$this->assertEquals(
			'',
			$this->form
				->buildForm()
				->addInput(new TextInput('Username', 'PKaiser', 32))
				->validateForm()
		);

		$this->assertEquals(
			'',
			$this->form
				->buildForm()
				->addInput(new TextInput('Username', 'PKaiser123', 32))
				->validateForm()
		);
	}

	/**
	 * Tests an invalid text input.
	 */
	public function testInvalidText(): void
	{
		$name = 'Password';
		$empty = '';
		$overflow = 'huiohuiohuio';
		$max_value = 8;

		$this->assertEquals(
			"$name: Please enter a value",
			$this->form
				->buildForm()
				->addInput(new TextInput('Password', $empty, $max_value))
				->validateForm()
		);

		$this->assertEquals(
			"$name: Length should be less than or equal to
				$max_value characters long",
			$this->form
				->buildForm()
				->addInput(new TextInput('Password', $overflow, $max_value))
				->validateForm()
		);
	}
}