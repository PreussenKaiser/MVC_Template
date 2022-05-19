<?php

namespace Core\Logging;

/**
 * The interface which implements logging.
 * 
 * @author PreussenKaiser
 */
interface LoggerInterface
{
    /**
	 * Writes a debug message.
	 *
     * @param string $message The message to write.
     */
    public function debug(string $message): void;

    /**
	 * Writes an info message.
	 *
     * @param string $message The message to write.
     */
    public function info(string $message): void;

    /**
	 * Writes a warning message.
	 *
     * @param string $message The message to write.
     */
    public function warning(string $message): void;

    /**
	 * Writes an error message.
	 *
     * @param string $message The message to write.
     */
    public function error(string $message): void;
}