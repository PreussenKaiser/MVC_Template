<?php

namespace Core;

use PDO;

/**
 * Contains a singleton for logging.<br>
 * Debug: 0, Info: 1<br>
 * Warning: 2, Error: 3
 */
final class Logger
{
    /**
	 * @var ?Logger The current class instance.
	 */
    private static ?Logger $instance = null;

    /**
	 * @var ?PDO The log database connection.
	 */
    private static ?PDO $connection = null;

    /**
	 * @var string The table to store logs in.
	 */
    private string $table_name;

	/**
	 * Initializes a new instance of the Logger singleton.
	 */
    private function __construct()
    {
		self::$connection = Database::getConnection();

		$this->loadSettings();
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
	 * Writes a debug message.
	 *
     * @param string $message The message to write.
     */
    public function debug(string $message): void
    {
        $this->writeMessage($message, 0);
    }

    /**
	 * Writes an info message.
	 *
     * @param string $message The message to write.
     */
    public function info(string $message): void
    {
        $this->writeMessage($message, 1);
    }

    /**
	 * Writes a warning message.
	 *
     * @param string $message The message to write.
     */
    public function warning(string $message): void
    {
        $this->writeMessage($message, 2);
    }

    /**
	 * Writes an error message.
	 *
     * @param string $message The message to write.
     */
    public function error(string $message): void
    {
        $this->writeMessage($message, 3);
    }

    /**
     * Writes the message and log level.
	 *
     * @param string $message The message to write.
     * @param int $level The log severity.
     */
    private function writeMessage(string $message, int $level): void
    {
		self::$connection
			->prepare(
				"INSERT INTO $this->table_name (level, message, date) 
				VALUES(?, ?, NOW())"
			)
			?->execute(array($level, $message));
    }
}
