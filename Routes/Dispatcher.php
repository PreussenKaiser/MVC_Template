<?php

/**
 * The backbone of this MVC framework.
 *
 * Dispatches a request to their destinations.
 */
class Dispatcher
{
	/**
	 * Parses the current request.
	 *
	 * Requests have this structure minus root:<br>
	 * [viewname]?[method_call]?[parameters]
	 */
    public static function dispatch(): void
    {
        $request = new Request();
        Router::parse($request);

        $controller = self::loadController($request);

        if (!is_null($request->action))
			$controller->{$request->action}($request->params);
    }

    /**
     * Creates a controller for the request.
	 *
	 * If no controller can be found,
	 * the request is assigned an ErrorController.
	 *
	 * @param Request The request to load the controller for.
     * @return Controller|ErrorController The controller for that request.
     */
    private static function loadController(Request $request): Controller|ErrorController
    {
        $name = $request->controller . 'Controller';
        $file = ROOT . 'App/Controllers/' . $name . '.php';

        if (file_exists($file))
        {
            require($file);
        }
        else
        {
            require(ROOT . 'App/Controllers/ErrorController.php');
            $name = 'ErrorController';
        }

        return new $name();
    }
}