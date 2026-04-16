<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'executive_summary',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'slug' => 'string',
            'description' => 'string',
            'executive_summary' => 'string',
        ];
    }

    public function scopeSearch($query, $request)
    {
        return $query->when(
            $request->filled('name'), fn($q) => 
                $q->where('name', 'like', "%{$request->query('name')}%")
            )->when($request->filled('slug'), fn($q) => 
                $q->where('slug', 'like', "%{$request->query('slug')}%")
            )->when($request->filled('description'), fn($q) => 
                $q->where('description', 'like', "%{$request->query('description')}%")
            )->when($request->filled('executive_summary'), fn($q) => 
                $q->where('executive_summary', 'like', "%{$request->query('executive_summary')}%")
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
