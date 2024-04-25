<?php

namespace App\Repositories\Role;

use Spatie\Permission\Models\Role;

interface RoleInterface
{
    public function paginate($perPage = 5);

    public function create($name);
    public function update(Role $role, array $data);
    public function delete(Role $role);
    public function editRole( $role);
    public function findById($id);
    public function updateRoleName($role, $newName);
    public function syncPermissions($role, $permissions);
    public function deleteModelRolesByRoleId($roleId);

}
