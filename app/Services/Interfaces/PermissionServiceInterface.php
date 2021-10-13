<?php

namespace App\Services\Interfaces;

use App\Models\Permission;
use Illuminate\Http\Request;

interface PermissionServiceInterface extends BaseServiceInterface
{
    public function store(Request $request, Permission $permission): void;
    public function update(Request $request, Permission $permission): void;
    public function delete(Permission $permission): void;
}
