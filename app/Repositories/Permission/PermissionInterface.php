<?php

namespace App\Repositories\Permission;

use Spatie\Permission\Models\Permission;

interface PermissionInterface
{
    public function paginate($perPage = 5);
    public  function all();
    public function create(array $data);
    public function update(Permission $permission, array $data);
    public function delete(Permission $permission);
    public function givePermissionTo($role, $permission);
}
