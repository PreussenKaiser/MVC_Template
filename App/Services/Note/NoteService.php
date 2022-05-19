<?php

namespace App\Services\Note;

use App\Services\Database\Database;
use App\Services\Database\MySqlDatabase;
use Core\Validation\Form;
use Core\Validation\Inputs\TextInput;
use App\Models\Note;

/**
 * The service which pulls notes from a database.
 * 
 * @author PreussenKaiser
 * @uses Database The database to get notes with.
 */
final class NoteService implements NoteServiceInterface
{
    /**
     * The database to query notes with.
     * @var Database
     */
    private readonly Database $database;

    /**
     * Validates note values.
     * @var Form
     */
    private readonly Form $validator;

    /**
     * Initializes a new instance of the NoteService service.
     */
    public function __construct()
    {
        $this->database = new MySqlDatabase('note');
        $this->validator = new Form;
    }

    /**
     * Creates a note in the database.
     * 
     * @param Note $note The note to create.
     * @return string An error message if invalid,
     *                empty string if valid.
     */
    public function create(Note $note): string
    {
        $msg = $this->validateNote($note);

        if (!empty($msg))
            return $msg;

        $this->database->create([
            'content' => $note->getContent()
        ]);

        return '';
    }

    /**
     * Gets all notes from the database.
     * 
     * @return iterable A list of note objects.
     */
    public function read(): iterable
    {
        $notes = [];
        $query = $this->database->read();

        foreach ($query as $note) {
            array_push($notes, $this->newNote($note));
        }

        return $notes;
    }

    /**
     * Gets a note.
     * 
     * @param int $id The note to get.
     * @return Note The found note.
     */
    public function get(int $id): Note
    {
        return $this->newNote($this->database->get($id));
    }

    /**
     * Updates a note in the database.
     * 
     * @param Note $note The note to update.
     * @return string An error message if invalid,
     *                empty string if valid.
     */
    public function update(Note $note): string
    {
        $msg = $this->validateNote($note);

        if (!empty($msg))
            return $msg;

        $this->database->update(
            $note->getID(),
            ['content' => $note->getContent()]
        );

        return '';
    }

    /**
     * Deletes a note in the database.
     * 
     * @param int $id The id of the note to delete.
     */
    public function delete(int $id): void
    {
        $this->database->delete($id);
    }

    /**
     * Creates a new note from values in the database.
     * 
     * @param iterable $values The values to convert.
     * @return Note The converted note.
     */
    private function newNote(iterable $values): Note
    {
        return new Note(
            $values['content'] ?? '',
            $values['id'] ?? 0
        );
    }

    /**
     * Determines if a note is valid.
     * 
     * @param Note $note The note to validate.
     * @return string An error message if invalid,
     *                empty string if valid.
     */
    private function validateNote(Note $note): string
    {
        return $this->validator
                ->buildForm()
                ->addInput(new TextInput('Content', $note->getContent()))
                ->validateForm();
    }
}
