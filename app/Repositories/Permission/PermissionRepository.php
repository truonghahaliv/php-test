<?php

namespace App\Repositories\Permission;

use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionInterface
{
    protected Permission $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }
    public function all()
    {
        return Permission::all();
    }
    public function paginate($perPage = 5)
    {
        return $this->permission->paginate($perPage);
    }
    public function create(array $data)
    {
        return $this->permission->create(['name' => $data['name']]);
    }

    public function update(Permission $permission, array $data)
    {
        $permission->update($data);
        return $permission;
    }

    public function delete(Permission $permission)
    {
        return $permission->delete();
    }
    public function givePermissionTo($role, $permission)
    {
        $role->givePermissionTo($permission);
    }
}
