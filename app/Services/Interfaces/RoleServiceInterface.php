<?php

namespace App\Services\Interfaces;

use App\Models\Role;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

interface RoleServiceInterface extends BaseServiceInterface
{
    public function getUsers(Role $role, int $qty = null): Paginator;
    public function store(Request $request, Role $role): void;
    public function update(Request $request, Role $role): void;
    public function delete(Role $role): void;
    public function syncWithoutID(Role $role, int $id): bool;
}
