<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permission\StoreRequest;
use App\Models\Permission;
use App\Services\Interfaces\PermissionServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private PermissionServiceInterface $permissionService;
    private RoleServiceInterface $roleService;

    public function __construct(
        PermissionServiceInterface $permissionService,
        RoleServiceInterface $roleService,
    ) {
        $this->permissionService = $permissionService;
        $this->roleService = $roleService;
    }

    public function index()
    {
        $permissions = $this->permissionService->getPagination();
        return view('home.admin.permissions.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        $roles = $this->roleService->getAll();
        return view('home.admin.permissions.create', ['roles' => $roles]);
    }

    public function store(StoreRequest $request, Permission $permission)
    {
        $this->permissionService->store($request, $permission);

        return redirect()
            ->route('permissions.index')
            ->with('status', 'The permission added successfully!');
    }

    public function edit(Permission $permission)
    {
        return view('home.admin.permissions.edit', [
            'permission' => $permission, 
            'roles' => $this->roleService->getAll(),
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $this->permissionService->update($request, $permission);

        return redirect()
            ->route('permissions.index')
            ->with('status', 'The permission updated successfully!');
    }

    public function destroy(Permission $permission)
    {
        $this->permissionService->delete($permission);

        return redirect()
            ->route('permissions.index');
    }
}
