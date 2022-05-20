<?php

namespace Routes;

/**
 * The class that parse a request and assigns its properties.
 * 
 * @author PreussenKaiser
 */
final class Router
{
	/**
	 * Assigns request properties.
	 *
	 * @param Request $request The request to parse.
	 */
	public static function parse(Request $request): void
	{
		// removes trailing '/'
		$url = rtrim($request->getUrl(), '/');

		$exploded_url = explode('/', $url);
		$args = end($exploded_url);

		// when there are no arguments
		if ($args == PROJECT_NAME) {
			$request->setProperties();

			return;
		}

		$request->setProperties(
			...self::parseArgs($args)
		);
	}

	/**
	 * Gets the controller, action and parameters from url arguments.
	 *
	 * @param string $arguments The arguments to extract request properties from.
	 * @return iterable The found controller.
	 */
	private static function parseArgs(string $arguments): iterable
	{
		// * example url: home@index?1?hello

		// explodes into array and takes the first index: 'home'
		$controller = explode('@', $arguments)[0];

		// splits args by the '@', selects the last index: 'index?1?hello'
		// then it's split by '?', selecting the first index: 'index'
		$action = explode('?', explode('@', $arguments)[1])[0];

		// splits args by '?': [home@index, 1, hello]
		// removes the first index: [1, hello]
		$params = array_slice(explode('?', $arguments), 1);

		return [$controller, $action, $params];
	}
}