<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'description',
        'difficulty',
        'semester',
        'credits',
        'image',
    ];

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
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
