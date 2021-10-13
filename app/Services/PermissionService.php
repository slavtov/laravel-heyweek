<?php

namespace App\Services;

use App\Models\Permission;
use App\Services\Interfaces\PermissionServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionService extends BaseService implements PermissionServiceInterface
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function getPagination(int $qty = null): Paginator
    {
        return $this->model
            ->with('roles')
            ->paginate($qty);
    }

    public function store(Request $request, Permission $permission): void
    {
        $permission->name = Str::slug($request->name);

        $permission->save();
        $permission->roles()
            ->sync($request->role);
    }

    public function update(Request $request, Permission $permission): void
    {
        if ($request->name !== $permission->name)
            $request->validate(['name' => 'required|unique:permissions']);

        $this->store($request, $permission);
    }

    public function delete(Permission $permission): void
    {
        $permission->delete();
    }
}
