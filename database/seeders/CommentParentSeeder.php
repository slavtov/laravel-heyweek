<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $comment = Comment::where('parent_id', null)
                ->get()
                ->random();

            Comment::factory()
                ->create([
                    'post_id' => $comment->post_id,
                    'parent_id' => $comment->id,
                ]);
        }
    }
}
