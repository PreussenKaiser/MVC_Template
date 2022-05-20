<?php

namespace App\Services\Database;

use PDO;

/**
 * The class which defines base database behavior.
 * 
 * @author PreussenKaiser
 * @uses PDO To establish a database connection.
 */
abstract class Database
{
	/**
	 * The table to query.
	 * @var string
	 */
	public readonly string $table;

    /**
     * @var PDO The connection to establish.
     */
    protected static PDO $connection;

    /**
     * Initializes a new instance of the base Database class.
     * 
     * @param PDO $connection The connection to the database.
	 * @param string The table to query.
     */
    public function __construct(PDO $connection, string $table)
    {
		self::$connection = $connection;
		$this->table = $table;
    }

    /**
	 * Creates the model in the database.
	 * Data entered is in the form of key-value pair.
	 *
	 * @example Model 'first_name' => 'john'
	 * @param array $data The parameters to insert.
	 */
	public function create(array $data): void
	{
		// creates question marks for each value
		$marks = array_fill(0, count($data), '?');

		// the fields to create
		$fields = array_keys($data);

		// the values to supply those fields
		$values = array_values($data);

		$statement = self::$connection->prepare(
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
			->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Gets all values from a model.
	 *
	 * Retrieved data from the model is indexed by their column name.
	 *
	 * @paramt $id The model to get values from.
	 * @return iterable|false The values of the first occurrence of that model,
	 * 					      false if the model wasn't found.
	 */
	public function get(int $id): iterable|false
	{
		$statement = self::$connection->prepare(
			"SELECT * FROM $this->table
			 WHERE id = ?"
		);

		$statement->execute([$id]);
		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * Updates a model in the database.
	 *
	 * The ID specifies the model to update.
	 * Data entered is in the form of a key-value pair.
	 *
	 * @param int $id The model to update.
	 * @example Model 'first_name' => 'john'
	 * @param array $data The columns (keys) to update with fields (values).
	 */
	public function update(int $id, array $data): void
	{
		// the fields to update
		$fields = array_keys($data);

		// the values to put in those fields
		$values = array_values($data);

		// pairs fields to a '?' for sanitization
		$pairs = [];
		foreach ($fields as $field)
			$pairs[] .= "$field = ?";

		$statement = self::$connection->prepare(
			"UPDATE $this->table SET " .
			implode(',', $pairs) . " WHERE id = $id"
		);

		$statement->execute($values);
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
				->execute([$id]);
	}

	/**
	 * Gets the database connection.
	 *
	 * @return PDO The connection to establish.
	 */
	public final function getConnection(): PDO
	{
		return self::$connection;
	}
}
