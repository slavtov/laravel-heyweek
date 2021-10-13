<?php

namespace App\Services;

use App\Models\Role;
use App\Services\Interfaces\RoleServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleService extends BaseService implements RoleServiceInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getPagination(int $qty = null): Paginator
    {
        return $this->model
            ->with('permissions')
            ->paginate($qty);
    }

    public function getUsers(Role $role, int $qty = null): Paginator
    {
        return $role->users()
            ->paginate($qty);
    }

    public function store(Request $request, Role $role): void
    {
        $role->name = Str::lower($request->name);

        $role->save();
        $role->permissions()
            ->sync($request->permission);
    }

    public function update(Request $request, Role $role): void
    {
        if ($request->name !== $role->name)
            $request->validate(['name' => 'required|unique:roles']);

        $this->store($request, $role);
    }

    public function delete(Role $role): void
    {
        $role->delete();
    }

    public function syncWithoutID(Role $role, int $id): bool
    {
        $res = $role->users()
            ->syncWithoutDetaching($id);

        if (!$res['attached'])
            return false;

        return true;
    }
}
