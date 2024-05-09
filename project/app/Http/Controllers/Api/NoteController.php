<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\NoteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{

    public function __construct(private NoteRepositoryInterface $noteRepository)
    {
    }

    public function getUserNotes()
    {
        $notes = $this->noteRepository->getUserNotes();
        return response()->json(['success' => true, 'notes' => $notes]);
    }

    public function create(Request $request)
    {
        $params = $request->only(['title', 'description']);

        $validatedData = validator($params, [
            'title' => 'required|unique:notes|max:255',
            'description' => 'required'
        ]);

        if ($validatedData->fails()) {
            return response()->json(['success' => false, 'errors' => $validatedData->errors()], 422);
        }

        if (!$this->noteRepository->create($params))
            return response()->json(['success' => false, 'message' => 'Note has not been saved']);

        return response()->json(['success' => true]);
    }

    public function view($id)
    {
        $note = $this->noteRepository->getNote($id);

        if (!$note) {
            return response()->json(['success' => false, 'message' => 'Note not found']);
        }

        if ($note->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Access denied'],403);
        }

        return response()->json(['success' => true, 'note' => $note]);
    }

    public function update(Request $request)
    {
        $params = $request->only(['id', 'title', 'description']);

        $validatedData = validator($params, [
            'id' => 'required',
            'title' => 'required|unique:notes|max:255',
            'description' => 'required'
        ]);

        if ($validatedData->fails()) {
            return response()->json(['success' => false, 'errors' => $validatedData->errors()], 422);
        }

        $note = $this->noteRepository->getNote($params['id']);

        if (!$note) {
            return response()->json(['success' => false, 'message' => 'Note not found']);
        }

        if ($note->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Access denied'],403);
        }

        if (!$this->noteRepository->update($params, $note))
            return response()->json(['success' => false, 'message' => 'Note has not been saved']);

        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $params = $request->only(['id']);

        $note = $this->noteRepository->getNote($params['id']);

        if (!$note) {
            return response()->json(['success' => false, 'message' => 'Note not found']);
        }

        if ($note->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Access denied'],403);
        }

        $this->noteRepository->delete($note);

        return response()->json(['success' => true]);
    }
}
