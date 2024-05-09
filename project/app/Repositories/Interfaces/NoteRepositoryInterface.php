<?php

namespace App\Repositories\Interfaces;

use App\Models\Note;

interface NoteRepositoryInterface
{
    public function getUserNotes();

    public function create(array $data);

    public function update(array $data, Note $note);

    public function delete(Note $note);

    public function getNote($id);
}
