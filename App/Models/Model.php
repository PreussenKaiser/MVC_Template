<?php
namespace App\Models;

use Core\Database;
use Core\Logger;
use PDO;

/**
 * The base model class.
 *
 * Handles the querying of a database.
 */
abstract class Model
{
	/**
	 * @var Logger The logger to use for logging model processes.
	 */
	protected Logger $logger;

	/**
	 * @var string The table to interface with.
	 */
	protected string $table;

	/**
	 * @var ?PDO The database connection for the model.
	 */
	private static ?PDO $connection = null;

	/**
	 * Initializes a new instance of the Model class.
	 *
	 * @param string $table The table to interface with.
	 */
	public function __construct(string $table)
	{
		if (is_null(self::$connection))
			self::$connection = Database::getConnection();

		$this->logger = Logger::getInstance();
		$this->table = $table;
	}

	/**
	 * Creates the model in the database.<br>
	 * Data entered is in the form of key-value pair.
	 *
	 * For example: 'first_name' => 'john'
	 *
	 * @param array $data The parameters to insert.
	 */
	public function create(array $data): void
	{
		$marks = array_fill(0, count($data), '?');
		$fields = array_keys($data);
		$values = array_values($data);

		$statement = self::$connection->prepare
		(
			"INSERT INTO $this->table 
			(" . implode(',', $fields) . ")
			VALUES(".implode(',', $marks).")",
		);

		$statement->execute($values);
	}

	/**
	 * Gets all instances of a model.
	 *
	 * Retrieved instances are indexed by their column name.
	 *
	 * @return iterable The result of selecting all models.
	 */
	public function read(): iterable
	{
		return self::$connection
			->query("SELECT * FROM $this->table")
			->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * Gets all values from a model.
	 *
	 * Retrieved data from the model is indexed by their column name.
	 *
	 * @param int $id The model to get values from.
	 * @return iterable The values of the first occurrence of that model.
	 */
	public function get(int $id): iterable
	{
		$statement = self::$connection->prepare
		(
			"SELECT * FROM $this->table
			WHERE id = ?"
		);

		$statement->execute(array($id));
		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * Updates a model in the database.
	 *
	 * The ID specifies the model to update.<br>
	 * Data entered is in the form of key-value pair.
	 *
	 * For example: 'first_name' => 'john'
	 *
	 * @param int $id The model to update.
	 * @param array $data The columns (keys) to update with fields (values).
	 */
	public function update(int $id, array $data): void
	{
		$fields = array_keys($data);
		$values = array_values($data);
		$pairs = array();

		foreach ($fields as $field)
			$pairs[] .= "$field = ?";

		$statement = self::$connection->prepare
		(
			"UPDATE $this->table SET " .
			implode(',', $pairs) . " WHERE id = $id"
		);

		$statement->execute($values);
		$this->logger->debug("Model updated in $this->table");
	}

	/**
	 * Deletes a specified model.
	 *
	 * @param int $id The model to delete.
	 */
	public function delete(int $id): void
	{
		self::$connection
				->prepare("DELETE FROM $this->table WHERE id = ?")
				->execute(array($id));
	}

	/**
	 * Gets the database connection for the model.
	 *
	 * Can be called in child classes to perform custom queries.
	 *
	 * @return PDO The database for the model.
	 */
	protected final function getDb(): PDO
	{
		return self::$connection;
	}
}