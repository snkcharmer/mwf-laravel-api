<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Resources\TodoResource;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;

class TodoController extends Controller
{
    // GET /api/todos
    public function index(Request $request)
    {
        $todos = Todo::search($request)
            ->sort($request)
            ->filterByDate($request)
            ->paginate($request->integer('per_page', 10));

        return TodoResource::collection($todos);
    }

    // POST /api/todos
    public function store(StoreTodoRequest $request)
    {
        $todo = Todo::create($request->validated());

        return new TodoResource($todo);
    }

    // GET /api/todos/{todo}
    public function show(Todo $todo)
    {
        return new TodoResource($todo);
    }

    // PUT/PATCH /api/todos/{todo}
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());

        return new TodoResource($todo);
    }

    // DELETE /api/todos/{todo}
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json([
            'message' => 'Todo successfully deleted.',
            'data' => new TodoResource($todo),
        ]);
    }
}
