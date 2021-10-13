<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(50)
            ->create(['user_id' => User::all()->random()])
            ->each(function ($post) {
                $post->views()
                    ->create();
                $category = Category::all()
                    ->random();
                $post->categories()
                    ->attach($category->id);
            });
    }
}
