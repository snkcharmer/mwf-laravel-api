<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'notes',
        'is_done',
        'status',
        'due_at',
    ];

    protected function casts(): array
    {
        return [
            'is_done' => 'boolean',
            'status' => 'string',
            'due_at' => 'datetime',
        ];
    }

    public function scopeSearch($query, $request)
    {
        return $query->when(
            $request->filled('title'), fn($q) => 
                $q->where('title', 'like', "%{$request->query('title')}%")
            )->when($request->has('is_done'), fn($q) => 
                $q->where('is_done', $request->boolean('is_done'))
            )->when($request->filled('status'), fn($q) =>
                $q->where('status', $request->string('status')->toString())
            );
    }
    public function scopeSort($query, $request)
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        // Whitelist valid columns to prevent SQL injection
        $validColumns = ['title', 'is_done', 'status', 'due_at', 'created_at'];
        
        if (!in_array($sortBy, $validColumns)) {
            $sortBy = 'created_at';
        }

        return $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
    }

    public function scopeFilterByDate($query, $request)
    {
        return $query->when($request->date('from_date'), fn($q, $date) => 
            $q->whereDate('due_at', '>=', $date)
        )->when($request->date('to_date'), fn($q, $date) => 
            $q->whereDate('due_at', '<=', $date)
        );
    }
}
