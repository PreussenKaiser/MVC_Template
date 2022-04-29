<?php

namespace Config;

use Routes\Dispatcher;
use Core\Services\Logger;

use Exception;

/**
 * The class that runs configuration.
 */
final class Bootstrap
{
    /**
     * @var Logger Logs application processes.
     */
    private Logger $logger;

    /**
     * @var Dispatcher What to dispatch requests with.
     */
    private Dispatcher $dispatcher;

    /**
     * Initializes a new instance of the Bootstrap class.
     */
    public function __construct() {
        $this->logger = Logger::getInstance();
        $this->dispatcher = new Dispatcher;
    }

    /**
     * Initializes the application.
     */
    public function init(): void
    {
        session_start();
        App::loadConfig();

        try {
            $this->dispatcher->dispatch();
        }
        catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            header('Location: error@error');
        }
    }
}
