<?php
namespace Routes;

/**
 * Routes a request to it's controller.
 */
class Router
{
    /**
     * Assigns a request to it's controller.
	 *
     * @param Request $request The request to route.
     */
    public static function parse(Request $request): void
    {
        $url = rtrim($request->url, '/');
		$exploded_url = explode('/', $url);
		$controller = end($exploded_url);

		if ($controller == PROJECT_NAME)
		{
			$request->controller = INDEX;
			$request->params = array(
				'action' => INDEX,
				'args' => array()
			);

			return;
		}

		$params = array_slice(explode('?', $controller), 1);

		$request->controller = explode('?', $controller)[0];
		$request->params = array(
			'action' => $params[0] ?? '',
			'args' => array_slice($params, 1) ?? ''
		);
    }
}