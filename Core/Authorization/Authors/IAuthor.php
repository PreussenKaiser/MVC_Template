<?php

namespace Core\Authorization\Authors;

/**
 * Implements authorization logic for authors.
 */
interface IAuthor
{
    /**
     * Determines if the current action has correct authorization.
     * 
     * @return bool Wheither the action is authorized or not.
     */
    public function isAuthorized(): bool;
}