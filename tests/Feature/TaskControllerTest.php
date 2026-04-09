<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // INDEX
    // -------------------------------------------------------------------------

    /** @test */
    public function index_page_loads_successfully(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertOk();
        $response->assertViewIs('tasks.index');
    }

    /** @test */
    public function index_displays_tasks(): void
    {
        Task::factory()->count(3)->create();

        $this->get(route('tasks.index'))
             ->assertOk()
             ->assertViewHas('tasks');
    }

    /** @test */
    public function index_can_filter_by_status(): void
    {
        Task::factory()->pending()->create(['title' => 'Pending Task']);
        Task::factory()->completed()->create(['title' => 'Completed Task']);

        $response = $this->get(route('tasks.index', ['status' => 'pending']));

        $response->assertOk();
        $response->assertSee('Pending Task');
        $response->assertDontSee('Completed Task');
    }

    /** @test */
    public function index_can_filter_by_priority(): void
    {
        Task::factory()->create(['title' => 'High Priority Task', 'priority' => 'high']);
        Task::factory()->create(['title' => 'Low Priority Task',  'priority' => 'low']);

        $response = $this->get(route('tasks.index', ['priority' => 'high']));

        $response->assertOk();
        $response->assertSee('High Priority Task');
        $response->assertDontSee('Low Priority Task');
    }

    /** @test */
    public function index_can_search_by_title(): void
    {
        Task::factory()->create(['title' => 'Fix login bug']);
        Task::factory()->create(['title' => 'Write documentation']);

        $response = $this->get(route('tasks.index', ['search' => 'login']));

        $response->assertOk();
        $response->assertSee('Fix login bug');
        $response->assertDontSee('Write documentation');
    }

    // -------------------------------------------------------------------------
    // CREATE & STORE
    // -------------------------------------------------------------------------

    /** @test */
    public function create_page_loads_successfully(): void
    {
        $this->get(route('tasks.create'))
             ->assertOk()
             ->assertViewIs('tasks.create');
    }

    /** @test */
    public function can_store_a_valid_task(): void
    {
        $payload = [
            'title'       => 'New Task Title',
            'description' => 'Task description here.',
            'status'      => 'pending',
            'priority'    => 'medium',
            'due_date'    => now()->addDays(5)->format('Y-m-d'),
        ];

        $this->post(route('tasks.store'), $payload)
             ->assertRedirect(route('tasks.index'))
             ->assertSessionHas('success');

        $this->assertDatabaseHas('tasks', ['title' => 'New Task Title']);
    }

    /** @test */
    public function store_fails_when_title_is_missing(): void
    {
        $this->post(route('tasks.store'), [
            'status'   => 'pending',
            'priority' => 'medium',
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    public function store_fails_with_invalid_status(): void
    {
        $this->post(route('tasks.store'), [
            'title'    => 'Test Task',
            'status'   => 'invalid_status',
            'priority' => 'medium',
        ])->assertSessionHasErrors('status');
    }

    /** @test */
    public function store_fails_with_invalid_priority(): void
    {
        $this->post(route('tasks.store'), [
            'title'    => 'Test Task',
            'status'   => 'pending',
            'priority' => 'urgent', // not a valid value
        ])->assertSessionHasErrors('priority');
    }

    /** @test */
    public function store_fails_when_due_date_is_in_the_past(): void
    {
        $this->post(route('tasks.store'), [
            'title'    => 'Test Task',
            'status'   => 'pending',
            'priority' => 'medium',
            'due_date' => now()->subDay()->format('Y-m-d'),
        ])->assertSessionHasErrors('due_date');
    }

    // -------------------------------------------------------------------------
    // SHOW
    // -------------------------------------------------------------------------

    /** @test */
    public function can_view_a_single_task(): void
    {
        $task = Task::factory()->create(['title' => 'My Viewable Task']);

        $this->get(route('tasks.show', $task))
             ->assertOk()
             ->assertViewIs('tasks.show')
             ->assertSee('My Viewable Task');
    }

    // -------------------------------------------------------------------------
    // EDIT & UPDATE
    // -------------------------------------------------------------------------

    /** @test */
    public function edit_page_loads_with_task_data(): void
    {
        $task = Task::factory()->create(['title' => 'Editable Task']);

        $this->get(route('tasks.edit', $task))
             ->assertOk()
             ->assertViewIs('tasks.edit')
             ->assertSee('Editable Task');
    }

    /** @test */
    public function can_update_a_task(): void
    {
        $task = Task::factory()->create(['title' => 'Old Title', 'status' => 'pending']);

        $this->put(route('tasks.update', $task), [
            'title'    => 'Updated Title',
            'status'   => 'in_progress',
            'priority' => 'high',
        ])->assertRedirect(route('tasks.show', $task))
          ->assertSessionHas('success');

        $this->assertDatabaseHas('tasks', [
            'id'     => $task->id,
            'title'  => 'Updated Title',
            'status' => 'in_progress',
        ]);
    }

    /** @test */
    public function update_fails_when_title_is_missing(): void
    {
        $task = Task::factory()->create();

        $this->put(route('tasks.update', $task), [
            'status'   => 'pending',
            'priority' => 'medium',
        ])->assertSessionHasErrors('title');
    }

    // -------------------------------------------------------------------------
    // DESTROY
    // -------------------------------------------------------------------------

    /** @test */
    public function can_delete_a_task(): void
    {
        $task = Task::factory()->create();

        $this->delete(route('tasks.destroy', $task))
             ->assertRedirect(route('tasks.index'))
             ->assertSessionHas('success');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}