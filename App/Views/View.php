<?php
/** The class that represents a view.. */
class View
{
	/**
	 * Render the view.
	 * @param string $name The view to render.
	 * @param array $params Optional parameters for the view.
	 */
    public function render(string $name, array $params = array()): void
    {
		extract($params, EXTR_SKIP);
        require(ROOT . 'App/Views/Layouts/' . $name . '.php');
    }
}