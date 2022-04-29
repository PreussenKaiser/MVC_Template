<?php

namespace App\Controllers;

use App\Views\View;
use Core\Services\Logger;

/**
 * The base controller.
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
	 * Initializes a new instance of the Controller class.
	 */
	protected function __construct()
    {
		$this->logger = Logger::getInstance();
		$this->view = new View;
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

		if (method_exists($this, $method)) {
			call_user_func_array([$this, $method], ...$args);
		}
	}
}