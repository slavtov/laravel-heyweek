<?php

namespace App\Models;

use App\Scopes\Post\LangScope;
use App\Scopes\StatusScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Post extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new StatusScope);
        static::addGlobalScope(new LangScope);
    }

    public function views()
    {
        return $this->hasOne(PostView::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFindByAlias($query, string $alias)
    {
        return $query->with(['views', 'categories'])
            ->where('alias', $alias)
            ->firstOrFail();
    }

    public function scopeViewsJoin($query)
    {
        return $query->join('post_views', 'post_views.post_id', 'posts.id');
    }

    public function scopeActiveViews($query, Carbon $date)
    {
        return $query->where('post_views.updated_at', '>=', $date);
    }

    public function scopeSearch($query, string $q)
    {
        return $query->with(['views', 'categories'])
            ->where('title_' . App::currentLocale(), 'like', '%' . $q . '%')
            ->orWhere('body_' . App::currentLocale(), 'like', '%' . $q . '%')
            ->withCount('comments')
            ->viewsJoin()
            ->latest('post_views.all');
    }

    public function scopeInActive($query)
    {
        return $query->where('status', false);
    }

    public function scopeLatestInActive($query)
    {
        return $query->withoutGlobalScope(StatusScope::class)
            ->inActive()
            ->latest();
    }

    public function scopeWithQuery($query, ?int $qty, string | array | null $queryParam)
    {
        return $query->latest()
            ->paginate($qty, '*', 'post')
            ->appends($queryParam);
    }
}
