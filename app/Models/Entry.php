<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    /** @use HasFactory<\Database\Factories\EntryFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'organization',
        'location',
        'type',
        'start_date',
        'end_date',
    ];
}
