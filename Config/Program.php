<?php

namespace Config;

use App\Services\Database\MySqlDatabase;
use App\Services\Note\NoteService;
use Core\Logging\LoggerInterface;
use Core\Logging\Logger;
use Routes\Dispatcher;

use DI\Container;

use Exception;

/**
 * The class that acts as the main entry-point for the application.
 * 
 * @author PreussenKaiser
 * @uses LoggerInterface For logging.
 */
final class Program
{
    /**
     * The program's service container.
     * @var Container
     */
    public static Container $container;

    /**
     * Logs application processes.
     * @var LoggerInterface
     */
    private readonly LoggerInterface $logger;

    /**
     * What to dispatch requests with.
     * @var Dispatcher
     */
    private readonly Dispatcher $dispatcher;

    /**
     * Initializes a new instance of the Program class.
     */
    public function __construct()
    {
        self::$container = new Container;
        $this->logger = Logger::getInstance();
        $this->dispatcher = new Dispatcher;
    }

    /**
     * Initializes the application.
     */
    public function init(): void
    {
        session_start();
        Config::loadConfig();
        $this->buildContainer();

        try {
            $this->dispatcher->dispatch();
        }
        catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            header('Location: error@error');
        }
    }

    /**
     * Builds the PHP-DI service container.
     */
    private function buildContainer(): void
    {
        self::$container->set('Logger', Logger::getInstance());
        self::$container->set('NoteService', new NoteService);
    }
}
