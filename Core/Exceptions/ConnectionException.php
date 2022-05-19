<?php

namespace Core\Exceptions;

use Exception;

/**
 * The exception that represents a failure to establish a remote connection.
 * 
 * @author PreussenKaiser
 */
class ConnectionException extends Exception
{
    /**
     * Initializes a new instance of the ConnectionException exception.
     * 
     * @param string $message Where and or why the connection failed.
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
