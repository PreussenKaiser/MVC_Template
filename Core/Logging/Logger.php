<?php

namespace Core\Logging;

use App\Services\Database\Database;
use App\Services\Database\MySqlDatabase;

/**
 * Contains a singleton for logging.
 * 
 * Debug: 0, Info: 1,
 * Warning: 2, Error: 3
 * 
 * @uses Database The database to log to.
 * @author PreussenKaiser
 */
final class Logger implements LoggerInterface
{
    /**
	 * @var ?Logger The current class instance.
	 */
    private static ?Logger $instance = null;

    /**
     * @var Database The database to log to.
     */
    private Database $database;

    /**
	 * @var string The table to store logs in.
	 */
    private string $table_name;

	/**
	 * Initializes a new instance of the Logger singleton.
	 */
    private function __construct()
    {
        $this->loadSettings();

		$this->database = new MySqlDatabase($this->table_name);
    }

    /**
     * Gets the current logger instance.
	 *
     * @return Logger The current instance.
     */
    public static function getInstance(): Logger
    {
        if (is_null(self::$instance)) {
			self::$instance = new self();
		}

        return self::$instance;
    }

    /**
	 * Loads settings from log_settings.ini
	 */
    private function loadSettings(): void
    {
        $settings = parse_ini_file('../Config/config.ini');

        $this->table_name = $settings['table_name'];
    }

    /**
	 * Writes a debug message to the database.
	 *
     * @param string $message The message to write.
     */
    public function debug(string $message): void
    {
        $this->writeMessage($message, 0);
    }

    /**
	 * Writes an info message to the database.
	 *
     * @param string $message The message to write.
     */
    public function info(string $message): void
    {
        $this->writeMessage($message, 1);
    }

    /**
	 * Writes a warning message to the database.
	 *
     * @param string $message The message to write.
     */
    public function warning(string $message): void
    {
        $this->writeMessage($message, 2);
    }

    /**
	 * Writes an error message to the database.
	 *
     * @param string $message The message to write.
     */
    public function error(string $message): void
    {
        $this->writeMessage($message, 3);
    }

    /**
     * Converts the Logger class into a string.
     * 
     * @return string The string representation of the Logger.
     */
    public function __toString(): string
    {
        return Logger::class;
    }

    /**
     * Writes the message and log level.
	 *
     * @param string $message The message to write.
     * @param int $level The log severity.
     */
    private function writeMessage(string $message, int $level): void
    {
		$this->database
            ->getConnection()
			->prepare(
				"INSERT INTO $this->table_name (level, message, date) 
				VALUES(?, ?, NOW())"
			)
			?->execute(array($level, $message));
    }
}
