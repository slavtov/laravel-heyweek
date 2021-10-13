<?php

namespace App\Models;

use App\Scopes\LangScope;
use App\Scopes\Post\StatusScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new LangScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class)
            ->withoutGlobalScope(StatusScope::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInActive($query)
    {
        return $query->where('status', false);
    }
}
