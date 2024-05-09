<?php

namespace App\Repositories;

use App\Models\Note;
use App\Repositories\Interfaces\NoteRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class NoteRepository implements NoteRepositoryInterface
{

    public function getUserNotes()
    {
        return Cache::remember('user_notes_' . Auth::id(), 3600, function () {
            return Note::where('user_id', Auth::id())->get();
        });
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        $note = Note::create($data);

        if ($note)
            Cache::forget('user_notes_' . Auth::id());

        return $note;
    }

    public function update(array $data,Note $note)
    {
        if ($note->update($data)) {
            Cache::forget('user_notes_' . Auth::id());
            return true;
        }

        return false;
    }

    public function delete(Note $note)
    {
        if ($note->delete()) {
            Cache::forget('user_notes_' . Auth::id());
            return true;
        }

        return false;
    }

    public function getNote($id)
    {
        return Note::find($id);
    }
}
