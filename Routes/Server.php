<?php

namespace Routes;

/**
 * The class that handles server processing.
 *
 * Right now it only determines what path to take
 * in IIS and Apache servers.
 * 
 * @author PreussenKaiser
 */
final class Server
{
	/**
	 * Finds out what directory path to use.
	 *
	 * Currently, only determines paths for Microsoft-IIS and everything else
	 * (assuming the latter is styled after Apache).
	 *
	 * @return string The appropriate directory path for the server software.
	 */
	public static function determinePath(): string
	{
		// Removes versioning info.
		$software = explode('/', $_SERVER['SERVER_SOFTWARE'])[0];

		return match ($software) {
			'Microsoft-IIS' => '\\',
			default => '/',
		};
	}
}