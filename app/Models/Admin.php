<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{

    use HasApiTokens, Notifiable;

    public $timestamps = false;

    protected $guard  = 'admin';

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
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'must_change_password' => 'boolean',
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
