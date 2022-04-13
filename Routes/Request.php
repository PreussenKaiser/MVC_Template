<?php
namespace Routes;

use App\Controllers\Controller;
use Core\Logger;
use Exception;

/**
 * The class that represents a request.
 *
 * Requests have this structure minus root:<br>
 * [view_name]?[method_call]?[method_parameters].
 *
 * As of now, requests can only be one directory deep from root
 * else navigation breaks.
 */
class Request
{
    /**
	 * @var string The url for the request.
	 */
    public string $url;

	/**
	 * @var Controller|string
	 * Represents the request's controller.
	 * Located one directory away from root.
	 * <br>
	 * While processing the controller,
	 * a string will be temporarily assigned to this field.
	 */
    public Controller|string $controller;

	/**
	 * @var array
	 * Represents parameters to insert into a controller's method.
	 * Separated from the action by a '?'.
	 */
	public array $params;

    /**
	 * Initializes a new instance of a request.
	 */
    public function __construct()
    {
		try
		{
			$this->url = $this->extractProjectRoot($_SERVER['REQUEST_URI']);
			$this->params = array();
		}
		catch (Exception $ex)
		{
			Logger::getInstance()->error('Could not find project root');
		}
    }

	/**
	 * Finds the project root and returns the url from it.
	 *
	 * Runs incrementally from the file root.<br>
	 * Might be faster to run decrementally.
	 *
	 * @param string $url The project url.
	 * @return string The root directory plus the request url.
	 * @throws Exception If project root was not found.
	 */
	private function extractProjectRoot(string $url): string
	{
		$url = explode('/', $url);

		// Will break if the search term isn't found,
		// but it'd break farther down anyway.
		for ($i = 0; $i < count($url); $i++)
			if ($url[$i] == PROJECT_NAME)
				return implode('/', array_slice($url, $i));

		throw new Exception('Project root was not found!');
	}
}