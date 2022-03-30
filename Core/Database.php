<?php
/** Contains a singleton for the database connection. */
class Database
{
    /** @var Database The current instance of the class. */
    private static $instance;

    /** @var mysqli The current database connection. */
    private mysqli $connection;

    /** @var string The hostname of the database connection. */
    private string $hostname;

    /** @var string Username of the database connection. */
    private string $username;

    /** @var string Password for the database connection. */
    private string $password;

    /** @var string The database to connect to. */
    private string $database;

	/** @var Logger The logger to log database processes. */
	private Logger $logger;

    /** Initializes a new instance of the Database singleton. */
    private function __construct()
    {
        $this->loadSettings();

        $this->connection = new mysqli($this->hostname, $this->username, $this->password, $this->database);
		$this->logger = Logger::getInstance($this->connection);

        if (mysqli_connect_error())
		{
			$this->logger->error("Failed to connect to database: $this->database");
			trigger_error('Failed to connect to database.', E_ERROR);
		}
    }

    /**
     * Gets an instance of the database connection.
     * @return Database The current instance.
     */
    public static function getInstance(): Database
    {
        if (is_null(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    /**
     * Gets the current database connection.
     * @return mysqli The current database connection.
     */
    public function getConnection(): mysqli
    {
        return $this->connection;
    }

    /** Loads settings from db_settings.ini */
    private function loadSettings(): void
    {
        $settings = parse_ini_file('../Config/config.ini');

        $this->hostname = $settings['hostname'];
        $this->username = $settings['username'];
        $this->password = $settings['password'];
        $this->database = $settings['database'];
    }
}