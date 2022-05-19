<?php

namespace App\Controllers;

use App\Views\View;
use Core\Exceptions\UnknownRequestException;
use Core\Logging\LoggerInterface;
use Core\Logging\Logger;

/**
 * The class that represents a base controller.
 * 
 * @author PreussenKaiser
 * @uses LoggerInterface For logging.
 * @method __call
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
	protected LoggerInterface $logger;

	/**
	 * @var string The folder to get views from.
	 */
	protected string $view_folder;

	/**
	 * Initializes a new instance of the Controller class.
	 * 
	 * @param string $view_folder The folder to get views from.
	 */
	protected function __construct(string $view_folder)
    {
		$this->logger = Logger::getInstance();
		$this->view = new View;
		$this->view_folder = $view_folder;
	}

	/**
	 * Calls a child controller's method.
	 * Called when a child method is accessed outside it's context.
	 *
	 * @param string $name The name of the method.
	 * @param array $args The arguments for the method.
	 * @throws UnknownRequestException If the method does not exist.
	 */
	public final function __call(string $name, array $args): void
	{
		$method = $name . 'Action';

		if (!method_exists($this, $method))
			throw new UnknownRequestException("Could not find the method $method");

		call_user_func_array([$this, $method], ...$args);
	}
}