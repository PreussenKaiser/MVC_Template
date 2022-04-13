<?php
namespace Core\Tests;

use Core\Validator;
use PHPUnit\Framework\TestCase;

/**
 * The test for the Validator class.
 */
final class ValidatorTest extends TestCase
{
	/**
	 * @var Validator The validator to use for testing.
	 */
	private Validator $validator;

	/**
	 * Initializes a new instance of the ValidatorTest test.
	 */
	public function __construct()
	{
		parent::__construct();

		require_once('../Validator.php');
		$this->validator = new Validator();
	}

	/**
	 * Tests a valid form submission.
	 */
	public function testValid(): void
	{
		$_POST['username'] = 'PKaiser';
		$_POST['password'] = 'pepper';
		$max_values = array(32, 32);

		$expected = '';
		$actual = $this->validator
					->validateForm($_POST, $max_values);

		$this->assertEquals($expected, $actual);
	}

	/**
	 * Tests an invalid form submission where multiple inputs are empty.
	 */
	public function testEmpty(): void
	{
		$_POST['weight'] = '';
		$max_values = array(32, 32, 999);

		$expected = 'Weight must not be empty';
		$actual = $this->validator
					->validateForm($_POST, $max_values);

		$this->assertEquals($expected, $actual);
	}

	/**
	 * Tests validation when inputs overflow.
	 */
	public function testOverflow(): void
	{
		$_POST['weight'] = 9999;
		$max_values = array(32, 32, 999);

		$expected = 'Weight cannot exceed 999';
		$actual = $this->validator
					->validateForm($_POST, $max_values);

		$this->assertEquals($expected, $actual);
	}

	/**
	 * Tests a valid birthdate.
	 */
	public function testValidBirthdate(): void
	{
		$date = '2002-03-24 00:00:00';

		$expected = '';
		$actual = $this->validator->validateBirthdate($date);

		$this->assertEquals($expected, $actual);
	}

	/**
	 * Tests an invalid date.
	 */
	public function testInvalidBirthdate(): void
	{
		$date = '2102-03-24 00:00:00';

		$expected = 'Please enter a past date';
		$actual = $this->validator->validateBirthdate($date);

		$this->assertEquals($expected, $actual);
	}

	/**
	 * Tests an unknown date format.
	 */
	public function testNullDate(): void
	{
		$date = 'i definitely enjoy unit testing...';

		$expected = 'Could not read date';
		$actual = $this->validator->validateBirthdate($date);

		$this->assertEquals($expected, $actual);
	}
}