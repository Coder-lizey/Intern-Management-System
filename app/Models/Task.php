<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id', 
        'week_number', 
        'title', 
        'description', 
        'type', 
        'assigned_date',     // 👈 Controller me use ho rha hai
        'deadline',          // 👈 YEH MISSING THA (Ab add kar diya hai)
        'submission_date',   
        'git_link', 
        'status',
        'submission_text', 
        'submission_link', 
        'mentor_rating', 
        'mentor_feedback'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}