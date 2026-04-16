<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'description',
        'meta_data',
    ];

    protected function casts(): array
    {
        return [
            'meta_data' => 'array',
        ];
    }

    public function scopeSearch($query, $request)
    {
        return $query->when(
            $request->filled('action'), fn($q) => 
                $q->where('action', 'like', "%{$request->query('action')}%")
            )->when($request->filled('description'), fn($q) => 
                $q->where('description', 'like', "%{$request->query('description')}%")
            )->when($request->filled('entity_type'), fn($q) => 
                $q->where('entity_type', 'like', "%{$request->query('entity_type')}%")
            );
    }

    public function scopeSort($query, $request)
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        // Whitelist valid columns to prevent SQL injection
        $validColumns = ['created_at'];
        
        if (!in_array($sortBy, $validColumns)) {
            $sortBy = 'created_at';
        }

        return $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
    }

    public function scopeFilterByDate($query, $request)
    {
        return $query->when($request->date('from_date'), fn($q, $date) => 
            $q->whereDate('created_at', '>=', $date)
        )->when($request->date('to_date'), fn($q, $date) => 
            $q->whereDate('created_at', '<=', $date)
        );
    }
}
