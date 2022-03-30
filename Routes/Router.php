<?php
/** Routes a request to it's controller. */
class Router
{
    /**
     * Assigns a request to it's controller.
     * @param Request $request The request to route.
     */
    public static function parse(Request $request): void
    {
        $url = rtrim($request->url, '/');

		if ($url == PROJECT_NAME)
        {
            $request->controller = FRONTPAGE;
        }
        else
        {
			$exploded_url = explode('/', $url);
			$controller = $exploded_url[1];

			$request->controller = explode('?', $controller)[0];
			self::determineArgs($request, $controller);
        }
    }

	/**
	 * Parses arguments for the controller.
	 * @param Request $request The request to assign arguments to.
	 * @param string $controller The controller to find arguments for.
	 */
	private static function determineArgs(Request $request, string $controller): void
	{
		$exploded_action = array_slice(explode('?', $controller), 1);

		if (count($exploded_action) > 0)
		{
			$request->action = $exploded_action[0];
			$request->params = array_slice($exploded_action, 1);
		}
	}
}