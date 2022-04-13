<?php
namespace Config;

use Routes\Server;

/**
 * Contains configuration settings for the project.
 */
final class Config
{
	/**
	 * @var ?Config The current instance of the config.
	 */
	private static ?Config $instance = null;

	/**
	 * Loads project configurations.
	 */
	private function __construct()
	{
		$this->loadSettings();
		$this->determineRoot();
	}

	/**
	 * Loads configurations.
	 *
	 * Structured like a singleton get method because
	 * this shouldn't be loaded more than once.
	 */
	public static function loadConfig(): void
	{
		if (is_null(self::$instance))
			self::$instance = new self();
	}

	/**
	 * Loads framework settings.
	 *
	 * Settings must be located in config.ini
	 * in the same directory as this class.
	 */
	private function loadSettings(): void
	{
		$settings = parse_ini_file('config.ini');

		define('PROJECT_NAME', $settings['project_name']);
		define('INDEX', $settings['index']);
	}

	/** Initializes root constant. */
	private function determineRoot(): void
	{
		$path = Server::determinePath();

		define('ROOT', str_replace(
			'Public' . $path . 'index.php',
			'',
			$_SERVER['SCRIPT_FILENAME']
		));
	}
}