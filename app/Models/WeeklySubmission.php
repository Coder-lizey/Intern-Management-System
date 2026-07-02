<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklySubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'week_number',
        'git_link',
        'report_file',
        'status',
        'feedback',
        'rating'
    ];
}