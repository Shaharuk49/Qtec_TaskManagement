<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    
    protected $casts = [
        'due_date' => 'date',
    ];

   
    const STATUSES = ['pending', 'in_progress', 'completed'];

    
    const PRIORITIES = ['low', 'medium', 'high'];

 
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

   
    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }


    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%");
        });
    }

  
    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date
            && $this->due_date->isPast()
            && $this->status !== 'completed';
    }
}