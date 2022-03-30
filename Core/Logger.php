<?php
/**
 * Contains a singleton for logging.<br>
 * Debug: 0, Info: 1<br>
 * Warning: 2, Error: 3
 */
class Logger
{
    /** @var Logger The current class instance. */
    private static $instance;

    /** @var mysqli The log database connection. */
    private static mysqli $database;

    /** @var string The table to store logs in. */
    private string $table_name;

	/**
	 * Initializes a new instance of the Logger singleton.
	 * @param mysqli $database The database connection to log to.
	 */
    private function __construct(mysqli $database)
    {
		self::$database = $database;

		$this->loadSettings();
    }

    /**
     * Gets the current logger instance.
	 * @param mysqli $database The database connection to log to.
     * @return Logger The current instance.
     */
    public static function getInstance(mysqli $database): Logger
    {
        if (is_null(self::$instance))
            self::$instance = new self($database);

        return self::$instance;
    }

    /** Loads settings from log_settings.ini */
    private function loadSettings(): void
    {
        $settings = parse_ini_file('../Config/config.ini');

        $this->table_name = $settings['table_name'];
    }

    /**
	 * Writes a debug message.
     * @param string $message The message to write.
     */
    public function debug(string $message): void
    {
        $this->writeMessage($message, 0);
    }

    /**
	 * Writes an info message.
     * @param string $message The message to write.
     */
    public function info(string $message): void
    {
        $this->writeMessage($message, 1);
    }

    /**
	 * Writes a warning message.
     * @param string $message The message to write.
     */
    public function warning(string $message): void
    {
        $this->writeMessage($message, 2);
    }

    /**
	 * Writes an error message.
     * @param string $message The message to write.
     */
    public function error(string $message): void
    {
        $this->writeMessage($message, 3);
    }

    /**
     * Writes the message and log level.
     * @param string $message The message to write.
     * @param int $log_level The log severity.
     */
    private function writeMessage(string $message, int $log_level): void
    {
        if ($statement = self::$database->prepare("INSERT INTO $this->table_name (message, log_level) VALUES(?,?)"))
        {
            $statement->bind_param('si', $message, $log_level);
            $statement->execute();
        }
    }
}
