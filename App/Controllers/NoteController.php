<?php

namespace App\Controllers;

use App\Services\Note\NoteServiceInterface;
use Config\Program;
use App\Models\Note;

/**
 * The controller that renders note views.
 * Called when the url's controller is 'note'.
 * 
 * @author PreussenKaiser
 */
final class NoteController extends Controller
{
    /**
     * The service to query notes with.
     * @var NoteServiceInterface
     */
    private readonly NoteServiceInterface $note_service;

    /**
     * Initializes a new instance of the NoteController class.
     */
    public function __construct()
    {
        parent::__construct('Note');

        $this->note_service =
            Program::$container->get('NoteService');
    }

    /**
     * Creates a note.
     */
    protected function createAction(): void
    {
        $msg = '';

        if (isset($_POST['submit'])) {
            $msg = $this->note_service->create(
                new Note($_POST['content'] ?? '')
            );

            if (empty($msg)) {
                header('Location: home@index');
            }
        }

        $params = compact('msg');
        $this->view->render("$this->view_folder/note_create", $params);
    }

    /**
     * Updates a note.
     * 
     * @param int $id The note to update.
     */
    protected function updateAction(int $id): void
    {
        $msg = '';
        $content = $_POST['content'] ?? $this->note_service
                                            ->get($id)
                                            ->getContent();

        if (isset($_POST['submit'])) {
            $msg = $this->note_service->update(
                new Note($_POST['content'] ?? '', $id)
            );

            if (empty($msg)) {
                header('Location: home@index');
            }
        }

        $params = compact(
            'msg', 'content',
            'id'
        );
        $this->view->render("$this->view_folder/note_update", $params);
    }

    /**
     * Deletes a note.
     * 
     * @param int $id The note to delete.
     */
    protected function deleteAction(int $id): void
    {
        $this->note_service->delete($id);

        header('Location: home@index');
    }
}
