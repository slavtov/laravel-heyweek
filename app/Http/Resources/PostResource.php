<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $locale = App::currentLocale();

        return [
            'id' => $this->id,
            'title' => $this['title_' . $locale],
            'body' => $this['body_' . $locale],
            'views' => $this->views->all,
            'img' => $this['img_' . $locale] ? asset($this['img_' . $locale]) : asset('img/default.png'),
            'comments_count' => $this->comments_count,
            'categories' => $this->categories->map(function ($category) use ($locale) {
                return [
                    'name' => $category['name_' . $locale], 
                    'color' => $category->color,
                    'link' => route('category.show', $category->alias)
                ];
            }),
            'link' => route('post.show', $this->alias),
        ];
    }
}
