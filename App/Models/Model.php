<?php
/** The class that represents a model. */
abstract class Model
{
	/** @var Logger The logger to use for logging model processes. */
	protected Logger $logger;

	/** @var mysqli The database connection for the model. */
	private static $database;

	/** @var string The table to interface with. */
	private string $table;

	/**
	 * Initializes a new instance of the Model class.
	 * @param string $table_name The table to interface with.
	 */
	public function __construct(string $table_name)
	{
		if (is_null(self::$database))
			self::$database = Database::getInstance()->getConnection();

		$this->logger = Logger::getInstance(self::$database);
		$this->table = $table_name;
	}

	/**
	 * Gets all instances of a model.
	 * @return iterable The result of selecting all models.
	 */
	public function getAll(): iterable
	{
		return self::$database
			->query("SELECT * FROM $this->table")
			->fetch_all(\PDO::FETCH_ASSOC);
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

		$statement = self::$database->prepare
		(
			"INSERT INTO $this->table 
			(" . implode(',', $fields) . ")
			VALUES(".implode(',', $marks).")"
		);

		$statement->bind_param
		(
			$this->getTypes($values),
			...$values
		);

		$statement->execute();
		$this->logger->debug("Model inserted into $this->table");
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

		$statement = self::$database->prepare
		(
			"UPDATE $this->table SET " .
			implode(',', $pairs) . " WHERE id = $id"
		);

		$statement->bind_param
		(
			$this->getTypes($values),
			...$values
		);

		$statement->execute();
		$this->logger->debug("Model updated in $this->table");
	}

	/**
	 * Deletes a specified model.
	 * @param int $id The model to delete.
	 */
	public function delete(int $id): void
	{
		self::$database->query
		(
			"DELETE FROM $this->table WHERE id = $id"
		);
	}

	/**
	 * Gets the database connection for the model.
	 * @return mysqli The database for the model.
	 */
	protected function getDb(): mysqli
	{
		return self::$database;
	}

	/**
	 * Gets the types of the values entered in.
	 *
	 * Used for dynamically binding types to values.
	 * Only identifies integers and strings.
	 *
	 * @param array $values The values to determine types of.
	 * @return string The resulting string.
	 */
	private function getTypes(array $values): string
	{
		$result = '';

		foreach ($values as $value)
			$result .= is_numeric($value) ? 'i' : 's';

		$this->logger->debug($result);
		return $result;
	}
}