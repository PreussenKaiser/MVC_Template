<?php

namespace Core\Exceptions;

use Exception;

/**
 * The exception that represents a failure to route a url request.
 * 
 * @author PreussenKaiser
 */
class UnknownRequestException extends Exception
{
    /**
     * Initializes a new instance of the UnknownRequestException exception.
     * 
     * @param string $message The reason for the exception.
     */
    public function __construct(string $message) {
        parent::__construct($message);
    }
}
