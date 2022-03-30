<?php
/** The controller that relays the error page. */
class ErrorController extends Controller
{
    /** Initializes a new instance of the ErrorController controller. */
    public function __construct()
    {
        parent::__construct();

		$this->view->render('error');
		$this->logger->error('Error controller called!');
    }
}