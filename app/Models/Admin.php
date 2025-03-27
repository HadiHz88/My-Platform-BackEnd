<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'name',
        'bio',
        'info',
        'email',
        'phone',
        'address',
        'image_url',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'github_url',
        'youtube_url',
        'must_change_password',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
        'must_change_password' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getMustChangePasswordAttribute()
    {
        return $this->must_change_password;
    }
}
