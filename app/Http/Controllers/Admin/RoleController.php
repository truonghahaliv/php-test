<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use App\Models\User;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Service\ValidatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    protected RoleRepository $roleRepository;
    protected $permissionRepository;
    protected $userRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository, UserRepository $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->userRepository = $userRepository;
    }

    public function index(): View
    {

        $roles = $this->roleRepository->paginate(5);

        // Return the products to a view
        return view('admin.roles.index', compact('roles'))->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function create(): View
    {
        $permissions = $this->permissionRepository->all();
        $users = $this->userRepository->all();
        return view("admin.roles.create", compact('permissions', 'users'));
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $role = $this->roleRepository->create(['name' => $validatedData['name']]);


        $permissionArray = [];
        if ($request->permission != null) {
            foreach ($request->permission as $permission) {
                if ($permission != null) {
                    $this->permissionRepository->givePermissionTo($role, $permission);

                }

            }
        }

        if ($request->users != null) {
            foreach ($request->users as $userId) {
                $user = $this->userRepository->find($userId);
                if ($user) {
                    $this->userRepository->assignRole($user, $role->id);
                }
            }
        }


        // Redirect the user to the index page with a success message
        return redirect()->route('role.index')->with('success', 'Roles created successfully.');


    }


    public function edit(Role $role): View
    {
        $role = $this->roleRepository->editRole($role);
        $permissions = $this->permissionRepository->all();
        $users = $this->userRepository->all();
        return view('admin.roles.edit', compact('role', 'permissions', 'users'));
    }

    public function update(UpdateRoleRequest $request, $id): RedirectResponse
    {

        $validatedData = $request->validated();

        $role = $this->roleRepository->findById($id);
        $this->roleRepository->update($role, $validatedData);


        $this->roleRepository->syncPermissions($role, $request->permission);

        $this->roleRepository->deleteModelRolesByRoleId($request->id);

        foreach ($request->users as $userId) {
            $user = $this->userRepository->find($userId);
            if ($user) {
                $this->userRepository->assignRole($user, $role->id);
            }
        }

        return redirect(route('role.index'))->with('success', 'Permission Updated Successfully');

    }

    public function destroy(Role $role): RedirectResponse
    {
        $this->roleRepository->delete($role);
        return redirect(route('role.index'))->with('success', 'Role Deleted Succesfully');
    }
}
