<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\AddRequest;
use App\Http\Requests\Admin\Role\DeleteRequest;
use App\Http\Requests\Admin\Role\StoreRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\Interfaces\PermissionServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private RoleServiceInterface $roleService;
    private PermissionServiceInterface $permissionService;
    private UserServiceInterface $userService;

    public function __construct(
        RoleServiceInterface $roleService,
        PermissionServiceInterface $permissionService,
        UserServiceInterface $userService,
    ) {
        $this->middleware('can:roles');

        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
        $this->userService = $userService;
    }

    public function index()
    {
        $roles = $this->roleService->getPagination();
        return view('home.admin.roles.index', ['roles' => $roles]);
    }

    public function create()
    {
        $permissions = $this->permissionService->getAll();
        return view('home.admin.roles.create', ['permissions' => $permissions]);
    }

    public function store(StoreRequest $request, Role $role)
    {
        $this->roleService->store($request, $role);

        return redirect()
            ->route('roles.index')
            ->with('status', 'The role added successfully!');
    }

    public function show(Role $role)
    {
        return view('home.admin.roles.show', [
            'role' => $role, 
            'users' => $this->roleService->getUsers($role),
        ]);
    }

    public function edit(Role $role)
    {
        return view('home.admin.roles.edit', [
            'role' => $role, 
            'permissions' => $this->permissionService->getAll(),
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $this->roleService->update($request, $role);

        return redirect()
            ->route('roles.index')
            ->with('status', 'The role updated successfully!');
    }

    public function destroy(Role $role)
    {
        $this->roleService->delete($role);

        return redirect()
            ->route('roles.index');
    }

    public function add(AddRequest $request, Role $role)
    {
        if ($request->isMethod('post')) {
            $user = $this->userService->getByUsername($request->name);

            if (!$user)
                return back()
                    ->withErrors('User is not found');

            if ($this->roleService->syncWithoutID($role, $user->id))
                return back()
                    ->withErrors('The user has already been added');

            return back()
                ->with('status', 'The user has been added successfully!');
        }

        return view('home.admin.roles.add', ['role' => $role]);
    }

    public function delete(DeleteRequest $request, User $user)
    {
        $this->userService->detachRole($request, $user);
        return back();
    }
}
