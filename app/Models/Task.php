<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 'description', 'status', 'deadline', 'start_date', 'end_date', 'assigned_to',
    ];

    protected $casts = [
        'deadline' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->orderBy('created_at', 'asc');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
