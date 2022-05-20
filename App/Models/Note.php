<?php

namespace App\Models;

/**
 * The model which represents a note.
 * 
 * @author PreussenKaiser
 */
final class Note
{
    /**
     * The unique identifer of the note.
     * @var int
     */
    private readonly int $id;

    /**
     * The notes content.
     * @var string
     */
    private readonly string $content;

    /**
     * Initializes a new instance of the Note model.
     * 
     * @param string $content The content of the node.
     * @param int $id The optional id of the note, default is 0.
     */
    public function __construct(string $content, int $id = 0)
    {
        $this->id = $id;
        $this->content = $content;
    }

    /**
     * Gets the notes id.
     * 
     * @return int The notes unique identifier.
     */
    public function getID(): int
    {
        return $this->id;
    }

    /**
     * Gets the notes content.
     * 
     * @return string The content of the note.
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
