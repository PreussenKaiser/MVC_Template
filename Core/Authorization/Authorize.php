<?php

namespace Core\Authorization;

use Core\Authorization\Authors\IAuthor;

/**
 * The class that handles authorization.
 */
final class Authorize
{
    /**
     * Authorizes an action.
     * 
     * If authorization fails, the user is sent to an error page.
     * 
     * @param IAuthor $author The author to authorize.
     */
    public static function authorize(IAuthor $author): void
    {
        if (!$author->isAuthorized()) {
            header("Location: error@unauthorized?$author");
        }
    }
}
