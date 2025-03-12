<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'cover_url',
        'publisher',
        'published_date',
        'page_count',
        'status',
        'progress_percentage',
        'started_at',
        'finished_at'
    ];

    protected $casts = [
        'published_date' => 'date',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}
