<?php
namespace App\Controllers;

/**
 * The controller for the error view.
 */
final class ErrorController extends Controller
{
    /**
	 * Initializes a new instance of the ErrorController controller.
	 */
    public function __construct()
    {
        parent::__construct(array());

		$this->view->render('Error/error');
		$this->logger->error('Error controller called!');
    }
}