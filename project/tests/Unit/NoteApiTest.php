<?php

namespace Tests\Unit;

use App\Models\Note;
use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class NoteApiTest extends TestCase
{

    public function testGetUserNotes()
    {
        $response = $this->getJson('/api/note/get-user-notes');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'title' => 'Test note 1',
                        'description' => 'Test description 1'
                    ],
                    [
                        'title' => 'Test note 2',
                        'description' => 'Test description 2'
                    ]
                ]
            ]);
    }

    public function testCreateNote()
    {
        $response = $this->postJson('/api/note/create', [
            'user_id' => 1,
            'title' => 'Test note',
            'description' => 'Test description'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Note created',
                'data' => [
                    'user_id' => 1,
                    'title' => 'Test note',
                    'description' => 'Test description'
                ]
            ]);
    }

    public function testViewNote()
    {
        $note = Note::factory()->create();
        $response = $this->getJson('/api/note/view/' . $note->id);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $note->id,
                    'user_id' => $note->user_id,
                    'title' => $note->title,
                    'description' => $note->description
                ]
            ]);
    }

    public function testUpdateNote()
    {
        $note = Note::factory()->create();
        $response = $this->putJson('/api/note/update', [
            'id' => $note->id,
            'user_id' => 2,
            'title' => 'Test note 2',
            'description' => 'Test description 2'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Note updated',
                'data' => [
                    'id' => $note->id,
                    'user_id' => 2,
                    'title' => 'Test note 2',
                    'description' => 'Test description 2'
                ]
            ]);
    }

    public function testDeleteNote()
    {
        $note = Note::factory()->create();
        $response = $this->deleteJson('/api/note/delete', [
            'id' => $note->id
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Note deleted'
            ]);

        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }
}
