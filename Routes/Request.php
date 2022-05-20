<?php

namespace Routes;

use App\Controllers\Controller;

use Exception;

/**
 * The class that represents a request.
 *
 * Requests have this structure minus root:<br>
 * [view_name]@[method_call]?[method_parameters].
 *
 * As of now, requests can only be one directory deep from root
 * or else navigation breaks.
 * 
 * @author PreussenKaiser
 */
final class Request
{
    /**
	 * @var string The url for the request.
	 */
    private readonly string $url;

	/**
	 * Represents the request's controller.
	 * 
	 * While processing the controller,
	 * a string will be temporarily assigned to this field.
	 * @var Controller|string
	 */
    private Controller|string $controller;

	/**
	 * The action to execute in a controller.
	 * @var string
	 */
	private string $action;

	/**
	 * Represents parameters to insert into a controller's method.
	 * Separated from the action by a '?'.
	 * @var array
	 */
	private array $params;

    /**
	 * Initializes a new instance of the Request class.
	 */
    public function __construct()
    {
		$this->url = $this->extractProjectRoot($_SERVER['REQUEST_URI']);
		$this->action = INDEX;
		$this->params = [];
    }

	/**
	 * Gets the request's url.
	 *
	 * @return string The url for the request.
	 */
	public function getUrl(): string
	{
		return $this->url;
	}

	/**
	 * Gets the request's controller.
	 *
	 * @return string The controller for the request.
	 */
	public function getController(): string
	{
		return $this->controller;
	}

	/**
	 * Gets the request's action.
	 *
	 * @return string The method to call in the request's controller.
	 */
	public function getAction(): string
	{
		return $this->action;
	}

	/**
	 * Gets the request's parameters.
	 *
	 * @return array The parameters for the controller action.
	 */
	public function getParams(): array
	{
		return $this->params;
	}

	/**
	 * Sets request properties.
	 * 
	 * Default parameters point to the index page.
	 *
	 * @param string $controller The request's controller.
	 * @param string $action The controller method to execute.
	 * @param array $params The parameters for the method.
	 */
	public function setProperties(string $controller = INDEX, string $action = 'index',
								  array $params = []): void
	{
		$this->controller = $controller;
		$this->action = $action;
		$this->params = $params;
	}

	/**
	 * Finds the project root and returns the url from it.
	 *
	 * Runs incrementally from the file root.
	 * Might be faster to run decrementally.
	 *
	 * @param string $url The project url.
	 * @return string The root directory plus the request url.
	 * @throws Exception If project root was not found.
	 */
	private function extractProjectRoot(string $url): string
	{
		$url = explode('/', $url);

		// ! will break if the search term isn't found,
		// ! but it'd break farther down anyway
		for ($i = 0; $i < count($url); $i++) {
			if ($url[$i] == PROJECT_NAME)
				return implode('/', array_slice($url, $i));
		}

		throw new Exception('Project root was not found!');
	}
}