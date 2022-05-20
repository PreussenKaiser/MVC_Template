<?php

namespace App\Services\Database;

use Core\Exceptions\ConnectionException;

use PDO;
use Exception;

/**
 * The class that handles querying to a MySQL database.
 * 
 * @author PreussenKaiser
 */
class MySqlDatabase extends Database
{
    /**
     * The host who's connecting.
     * @var string
     */
    private readonly string $hostname;

    /**
     * The user who's connecting.
     * @var string
     */
    private readonly string $username;

    /**
     * The password of the user connecting.
     * @var string
     */
    private readonly string $password;

    /**
     * The name of the database to connect to.
     * @var string
     */
    private readonly string $database;

    /**
     * Initalizes a new instance of the MySqlDatabase class.
     * 
     * @param string $table The table to query.
     * @throws ConnectionException If the database connection fails.
     */
    public function __construct(string $table)
    {
        $this->loadSettings();

        $con_str = "mysql:host=$this->hostname;
                    dbname=$this->database";

        try {
            $pdo = new PDO(
                $con_str, $this->username,
                $this->password,
            );

            parent::__construct($pdo, $table);
        }
        catch (Exception) {
            throw new ConnectionException(
                'There was a problem connection to the MySQL database'
            );
        }
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
