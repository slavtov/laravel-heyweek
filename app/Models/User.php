<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function isAdmin() {
        return $this->roles()
            ->where('name', 'admin')
            ->exists();
    }

    public function isCreator() {
        return $this->roles()
            ->exists();
    }

    public function permission($permission)
    {
        foreach ($this->roles as $role) {
            $res = $role->permissions
                ->pluck('name')
                ->contains($permission);

            if ($res)
                return true;
        }
    }

    public function scopeFindByName($query, $name)
    {
        return $query->firstWhere('name', $name);
    }
}
