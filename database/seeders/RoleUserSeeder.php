<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = Role::where('name', 'admin')
            ->value('id');

        User::find(1)
            ->roles()
            ->attach($id);
    }
}
