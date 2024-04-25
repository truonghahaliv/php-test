<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Service\ValidatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    protected RoleRepository $roleRepository;
    protected $permissionRepository;
    protected $userRepository;
    protected ValidatorService $validatorService;

    public function __construct(RoleRepository $roleRepository, ValidatorService $validatorService, PermissionRepository $permissionRepository, UserRepository $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->validatorService = $validatorService;
        $this->permissionRepository = $permissionRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {

        $roles = $this->roleRepository->paginate(5);

        // Return the products to a view
        return view('admin.roles.index', compact('roles'))->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function create()
    {
        $permissions = $this->permissionRepository->all();
        $users = $this->userRepository->all();
        return view("admin.roles.create", compact('permissions', 'users'));
    }

    public function store(Request $request)
    {

        $validatedData = $this->validatorService->validateRoleData($request);
//
        $role = $this->roleRepository->create(['name' => $request->name]);


        foreach ($request->permission as $permission) {
            $this->permissionRepository->givePermissionTo($role, $permission);
        }


        foreach ($request->users as $userId) {
            $user = $this->userRepository->find($userId);
            if ($user) {
                $this->userRepository->assignRole($user, $role->id);
            }
        }

        // Redirect the user to the index page with a success message
        return redirect()->route('role.index')->with('success', 'Permission created successfully.');


    }


    public function edit(Role $role)
    {
        $role = $this->roleRepository->editRole($role);
        $permissions = $this->permissionRepository->all();
        $users = $this->userRepository->all();
        return view('admin.roles.edit', compact('role', 'permissions', 'users'));
    }

    public function update( Request $request, $id)
    {

        $validatedData = $this->validatorService->validateRoleData($request);

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

    public function destroy(Role $role)
    {
        $this->roleRepository->delete($role);
        return redirect(route('role.index'))->with('success', 'Role Deleted Succesfully');
    }
}
