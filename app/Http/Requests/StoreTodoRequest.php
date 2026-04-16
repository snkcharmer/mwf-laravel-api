<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'   => 'required|string|max:255',
            'notes'   => 'nullable|string',
            'is_done' => 'boolean',
            'status' => 'nullable|in:pending,in_progress,done',
            'due_at'  => 'nullable|date',
        ];
    }
}
