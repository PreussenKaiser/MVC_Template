<?php
namespace Core;

use PDO;

/**
 * Contains a singleton for the database connection.
 */
final class Database
{
    /**
	 * @var ?Database The current instance of the class.
	 */
    private static ?Database $instance = null;

    /**
	 * @var ?PDO The current database connection.
	 */
    private static ?PDO $connection = null;

    /**
	 * @var string The hostname of the database connection.
	 */
    private string $hostname;

    /**
	 * @var string Username of the database connection.
	 */
    private string $username;

    /**
	 * @var string Password for the database connection.
	 */
    private string $password;

    /**
	 * @var string The database to connect to.
	 */
    private string $database;

    /**
	 * Initializes a new instance of the Database singleton.
	 */
    private function __construct()
    {
        $this->loadSettings();
		$con_str = "mysql:host=$this->hostname;
					dbname=$this->database";

		self::$connection = new PDO(
			$con_str, $this->username, $this->password,
		);
    }

    /**
     * Gets the current database connection.
	 *
     * @return PDO The current database connection.
     */
    public static function getConnection(): PDO
    {
		if (is_null(self::$instance))
			self::$instance = new self();

        return self::$connection;
    }

    /**
	 * Loads settings from db_settings.ini
	 */
    private function loadSettings(): void
    {
        $settings = parse_ini_file('../Config/config.ini');

        $this->hostname = $settings['hostname'];
        $this->username = $settings['username'];
        $this->password = $settings['password'];
        $this->database = $settings['database'];
    }
}