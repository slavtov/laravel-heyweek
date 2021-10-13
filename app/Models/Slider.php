<?php

namespace App\Models;

use App\Scopes\LangScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'slider';

    protected static function booted()
    {
        static::addGlobalScope(new LangScope);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
