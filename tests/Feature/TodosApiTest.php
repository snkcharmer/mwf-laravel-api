<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodosApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_it_creates_a_todo(): void
    {
        $response = $this->postJson('/api/todos', [
            'title' => 'Buy milk',
            'notes' => '2 liters',
            'is_done' => false,
            'status' => 'pending',
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('data.title', 'Buy milk')
            ->assertJsonPath('data.notes', '2 liters')
            ->assertJsonPath('data.is_done', false)
            ->assertJsonPath('data.status', 'pending');

        $this->assertDatabaseHas(Todo::class, [
            'title' => 'Buy milk',
            'notes' => '2 liters',
            'is_done' => 0,
            'status' => 'pending',
        ]);
    }

    public function test_it_paginates_sorts_and_filters_todos(): void
    {
        Todo::factory()->create(['title' => 'Bravo', 'notes' => 'b']);
        Todo::factory()->create(['title' => 'Alpha', 'notes' => 'a']);
        Todo::factory()->create(['title' => 'Charlie', 'notes' => 'c']);

        $response = $this->getJson('/api/todos?limit=2&sortBy=title&sort=asc&keyword=a');

        $response
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.title', 'Alpha');

        $this->assertSame(2, $response->json('meta.per_page'));
    }
}
