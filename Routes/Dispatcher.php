<?php

namespace Routes;

use App\Controllers\Controller;

/**
 * Dispatches a request to their destinations.
 */
class Dispatcher
{
	/**
	 * Parses the current request.
	 *
	 * Requests have this structure minus root:<br>
	 * [view_name]?[method_call]?[parameters]
	 */
    public static function dispatch(): void
    {
        $request = new Request();
        Router::parse($request);

		// calls the controller
		self::loadController($request)
			->{$request->getAction()}($request->getParams());
    }

    /**
     * Creates a controller for the request.
	 *
	 * If no controller can be found,
	 * the request is assigned an ErrorController.
	 *
	 * @param Request The request to load the controller for.
	 * @return Controller The request's controller.
     */
    private static function loadController(Request $request): Controller
    {
        $name = ucfirst($request->getController()) . 'Controller';
        $file = ROOT . 'App/Controllers/' . $name . '.php';

        if (file_exists($file)) {
            require($file);
        }
        else {
            require(ROOT . 'App/Controllers/ErrorController.php');
            $name = 'ErrorController';
        }

		// prepends namespace.
		$name = 'App\\Controllers\\' . $name;

        return new $name($request->getParams());
    }
}