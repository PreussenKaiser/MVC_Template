<?php
/** The class that represents a controller. */
abstract class Controller
{
    /** @var View The view for the controller. */
    protected View $view;

	/** @var Logger The logger to log controller processes. */
	protected Logger $logger;

    /** Initializes a new instance of a Controller. */
	protected function __construct()
    {
        $this->view = new View();
		$this->logger = Logger::getInstance
		(
			Database::getInstance()->getConnection()
		);
    }

	/**
	 * Builds a table.
	 * @param array $cols The column names for the table.
	 * @return string The completed table.
	 */
	protected function buildTable(array $cols): string
	{
		$table =	'<table class="table text-white">' .
						'<thead>' .
							'<tr>';
							foreach ($cols as $col)
								$table .= "<th scope='col'>$col</th>";
		$table .=			'</tr>' .
						'</thead>' .
						'<tbody>';

		return $table;
	}
}