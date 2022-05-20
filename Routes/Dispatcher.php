<?php

namespace Routes;

use App\Controllers\Controller;
use Core\Exceptions\UnknownRequestException;

/**
 * Dispatches a request to their destinations.
 * 
 * @author PreussenKaiser
 */
final class Dispatcher
{
	/**
	 * Parses the current request.
	 *
	 * Requests have this structure minus root:
	 * [view_name]?[method_call]?[parameters]
	 */
    public function dispatch(): void
    {
        $request = new Request;
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
     * @throws UnknownRequestException If the request has an unknown controller.
     */
    private static function loadController(Request $request): Controller
    {
        // * example: requested controller is 'home'

        // 'home':
        // 'HomeController'
        $name = ucfirst($request->getController()) . 'Controller';

        // 'HomeController':
        // 'C:/(your_file_structure)/(project_name)/App/Controllers/HomeController.php'
        $file = ROOT . 'App/Controllers/' . $name . '.php';

        if (!file_exists($file)) {
            throw new UnknownRequestException('Could not find controller');
        }

        // prepends namespace.
        $name = 'App\\Controllers\\' . $name;

        require($file);
        return new $name();
    }
}