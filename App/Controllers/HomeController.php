<?php

namespace App\Controllers;

use Config\Program;
use App\Services\Note\NoteServiceInterface;
use App\Models\Note;

/**
 * The controller that displays home views.
 * Called when the url's controller is 'home'.
 * 
 * @author PreussenKaiser
 * @uses NoteServiceInterface To fetch user notes.
 */
final class HomeController extends Controller
{
    /**
     * The service to get notes with.
     * @var NoteServiceInterface
     */
    private readonly NoteServiceInterface $note_service;

    /**
     * Initializes a new instance of the HomeController controller.
     */
    public function __construct()
    {
        parent::__construct('Home');

        $this->note_service = 
            Program::$container->get('NoteService');
    }

    /**
     * Renders the frontpage view.
     */
    protected function indexAction(): void
    {
        $notes = $this->buildNotes(
            $this->note_service->read()
        );

        $params = compact('notes');
        $this->view->render(
            "$this->view_folder/frontpage",
             $params
        );
    }

    /**
     * Builds cards that represent notes.
     * 
     * @param iterable $notes The notes to build cards from.
     * @return string The notes as HTML cards.
     */
    private function buildNotes(iterable $notes): string
    {
        $result = '';

        foreach ($notes as $note) {
            if ($note instanceof Note) {
                $id = $note->getID();
                $content = $note->getContent();

                $result .= "
                            <div class='col-sm-6 col-lg-3'>
                                <div class='card bg-black text-white'>
                                    <div class='card-body'>
                                        <p class='card-text'>
                                            $content
                                        </p>
                                        <a class='btn btn-outline-light btn-sm' href='note@update?$id'>
                                            Update
                                        </a>
                                        <a class='btn btn-outline-danger btn-sm' href='note@delete?$id'>
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                           ";
            }
        }

        return $result;
    }
}
