<?php
namespace App\Controllers;

use App\Views\View;
use Core\Logger;
use Core\Validation\Form;

/**
 * The base controller class.
 */
abstract class Controller
{
    /**
	 * @var View The view for the controller.
	 */
    protected View $view;

	/**
	 * @var Logger The logger to log controller processes.
	 */
	protected Logger $logger;

	/**
	 * @var Form The class to use for form validation.
	 */
	protected Form $form;

	/**
	 * Initializes a new instance of the Controller class.
	 *
	 * @param array $params The parameters for the controller.
	 */
	protected function __construct(array $params)
    {
		$this->logger = Logger::getInstance();
		$this->view = new View();
		$this->form = new Form();
	}

	/**
	 * Calls a child controller's method.
	 *
	 * Called when a child method is accessed outside it's context.
	 *
	 * @param string $name The name of the method.
	 * @param array $args The arguments for the method.
	 */
	public final function __call(string $name, array $args): void
	{
		$method = $name . 'Action';

		if (method_exists($this, $method))
			call_user_func_array([$this, $method], ...$args);
	}

	/**
	 * Builds a table.
	 *
	 * Once called, the table should be followed by a closing tag.
	 *
	 * @param array $cols The column names for the table.
	 * @return string A table with a completed header and opening body tag.
	 */
	protected final function buildTable(array $cols): string
	{
		$table =	"<table class='table text-white'>
						<thead>
							<tr>";
							foreach ($cols as $col)
								$table .= "<th scope='col'>$col</th>";
		$table .=			"</tr>
						</thead>
						<tbody>";

		return $table;
	}
}