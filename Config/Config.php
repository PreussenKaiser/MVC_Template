<?php
/** Contains configuration settings for the project. */
class Config
{
	/** @var Config The current instance of the config. */
	private static $instance;

	/** Loads project configurations. */
	private function __construct()
	{
		$this->loadSettings();
		$this->determineRoot();
		$this->defineConstants();
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

		define('PROJECT_NAME', $settings['projectname']);
		define('FRONTPAGE', $settings['frontpage']);
	}

	/** Initializes root constant. */
	private function determineRoot(): void
	{
		$path = Server::determinePath();
		define('ROOT', str_replace('Public'.$path.'index.php', '', $_SERVER['SCRIPT_FILENAME']));
	}

	/** Creates constants for the application. */
	private function defineConstants(): void
	{
		/** The upload path for files. */
		define('UPLOAD_PATH', ROOT . 'Public/resources/uploaded_img/');

		/** The maximum size for uploaded files. */
		define("MAX_FILE_SIZE", 131072);

		/** The admin username. */
		define('AUTH_USERNAME', 'username');

		/** The admin password. */
		define('AUTH_PASSWORD', 'password');
	}
}