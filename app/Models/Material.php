<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'type',
        'url',
        'order',
        'topic_id'
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function views(): MorphMany
    {
        return $this->morphMany(View::class, 'viewable');
    }

    // Get total likes
    public function getLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }

    // Get total views
    public function getViewsCountAttribute(): int
    {
        return $this->views()->count();
    }

    protected $appends = ['likes_count', 'views_count'];
}
