<?php
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
    /** @var string The url for the request. */
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
	 * @var string|null
	 * Represents the method to call in the controller.
	 * Separated from the controller by a '?'.
	 */
    public $action;

	/**
	 * @var array
	 * Represents parameters to insert into a controller's method.
	 * Separated from the action by a '?'.
	 */
	public array $params;

	/** @var Logger The logger to log request details. */
	private Logger $logger;

    /** Initializes a new instance of a request. */
    public function __construct()
    {
		$database = Database::getInstance()->getConnection();
		$this->logger = Logger::getInstance($database);

		try
		{
			$this->url = $this->extractProjectRoot($_SERVER['REQUEST_URI']);
		}
		catch (Exception $ex)
		{
			$this->logger->error($ex->getMessage());
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