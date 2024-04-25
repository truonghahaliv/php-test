<?php

namespace App\Repositories\Role;


use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;

class   RoleRepository implements RoleInterface
{
    protected Role $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function paginate($perPage = 5)
    {
        return $this->role->paginate($perPage);
    }

    public function create($name)
    {
        return Role::create($name);
    }

    public function update(Role $role, array $data)
    {
        $role->update($data);
        return $role;
    }


    public function editRole($role)
    {
        return Role::where('id', $role->id)
            ->with('permissions', 'users')
            ->first();


    }
    public function delete(Role $role)
    {
        return $role->delete();
    }
    public function findById($id)
    {
        // TODO: Implement findById() method.
        return Role::where('id', $id)->first();
    }
    public function updateRoleName($role, $newName)
    {
        $role->name = $newName;
        $role->save();
    }

    public function syncPermissions($role, $permissions)
    {
        $role->syncPermissions($permissions);
    }
    public function deleteModelRolesByRoleId($roleId)
    {
        DB::table('model_has_roles')->where('role_id', $roleId)->delete();
    }
}
