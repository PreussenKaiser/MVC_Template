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
	 * [viewname]?[method_call]?[parameters]
	 */
    public static function dispatch(): void
    {
        $request = new Request();

        Router::parse($request);
		$controller = self::loadController($request);

		$controller->{$request->params['action']}($request->params['args']);
    }

    /**
     * Creates a controller for the request.
	 *
	 * If no controller can be found,
	 * the request is assigned an ErrorController.
	 *
	 * @param Request The request to load the controller for.
	 * @return Controller
     */
    private static function loadController(Request $request): Controller
    {
        $name = ucfirst($request->controller) . 'Controller';
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

		// prepends namespace.
		$name = 'App\\Controllers\\' . $name;

        return new $name($request->params);
    }
}