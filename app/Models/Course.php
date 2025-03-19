<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
