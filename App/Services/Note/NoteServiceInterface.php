<?php

namespace App\Services\Note;

use App\Models\Note;

/**
 * The interface that implements note query methods.
 * 
 * @author PreussenKaiser
 */
interface NoteServiceInterface
{
    /**
     * Creates a note in the service.
     * 
     * @param Note $note The note to create.
     * @return string An error message if invalid,
     *                empty string if valid.
     */
    public function create(Note $note): string;

    /**
     * Gets all notes from the service.
     * 
     * @return iterable A list of note objects.
     */
    public function read(): iterable;

    /**
     * Gets a note.
     * 
     * @param int $id The note to get.
     * @return Note The found note.
     */
    public function get(int $id): Note;

    /**
     * Updates a note in the service.
     * 
     * @param Note $note The note to update.
     * @return string An error message if invalid,
     *                empty string if valid.
     */
    public function update(Note $note): string;

    /**
     * Deletes a note in the service.
     * 
     * @param int $id The id of the note to delete.
     */
    public function delete(int $id): void;
}