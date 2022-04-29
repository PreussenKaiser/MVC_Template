<?php
namespace App\Views;

/**
 * The class that renders a view.
 */
class View
{
	/**
	 * Renders the view and injects parameters.
	 *
	 * @param string $view The view to render.
	 * @param array $params Optional parameters for the view.
	 */
    public function render(string $view, array $params = []): void
    {
		$view = ROOT . "App/Views/$view.php";

		extract($params, EXTR_SKIP);
        require(ROOT . 'App/Views/Shared/layout.php');
    }
}