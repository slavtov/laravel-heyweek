<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            RoleUserSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            CommentParentSeeder::class,
            SliderSeeder::class,
        ]);
    }
}
