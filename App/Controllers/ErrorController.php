<?php

namespace App\Controllers;

/**
 * The controller for error views.
 */
final class ErrorController extends Controller
{
    /**
	 * Initializes a new instance of the ErrorController controller.
	 */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Renders the error view.
     * 
     * Called when an unknown url is entered.
     */
    protected function errorAction(): void
    {
        $params = $this->generateError(
            'Oops, we had a problem finding that URL',
            'Please verify if what you entered is a valid page'
        );
        $this->view->render('Error/error', $params);

        $this->logger->error('Could not load page!');
    }

    /**
     * Renders the unauthorized view.
     * 
     * Called in the Authorize class when 
     * the user isn't authorized to visit a page.
     * 
     * @param string $author The user type the action belonges to.
     */
    protected function unauthorizedAction(string $author): void
    {
        $params = $this->generateError(
            'Oops, this area is restricted!',
            'Only ' . $author . 's have access to this page'
        );
        $this->view->render('Error/error', $params);

        $this->logger->error(
            "Unauthorized access to an $author page prevented"
        );
    }

    /**
     * Generates an error report.
     * 
     * The report is then displayed in the error view.
     * 
     * @param string $title The title of the error.
     * @param string $reason The reason for the error.
     * @return array The compacted report.
     */
    private function generateError(string $title, string $reason): array
    {
        return compact('title', 'reason');
    }
}