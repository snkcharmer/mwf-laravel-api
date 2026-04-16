<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'   => 'sometimes|required|string|max:255',
            'notes'   => 'nullable|string',
            'is_done' => 'boolean',
            'status' => 'sometimes|nullable|in:pending,in_progress,done',
            'due_at'  => 'nullable|date',
        ];
    }
}
