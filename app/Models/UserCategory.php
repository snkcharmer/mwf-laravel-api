<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    /** @use HasFactory<\Database\Factories\UserCategoryFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
        ];
    }

    public function scopeSearch($query, $request)
    {
        return $query->when(
            $request->filled('name'), fn($q) => 
                $q->where('name', 'like', "%{$request->query('name')}%")
            )->when($request->filled('description'), fn($q) => 
                $q->where('description', 'like', "%{$request->query('description')}%")
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
