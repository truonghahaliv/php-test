<?php

namespace App\Repositories\User;

use App\Models\User;
use function Laravel\Prompts\select;

class UserRepository implements UserInterface
{
    protected User  $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function paginate($perPage = 5)
    {
        return $this->user->orderBy('id', 'desc')->paginate($perPage);
    }
    public function find($id)
    {
        return $this->user->find($id);
    }
    public function all( )
    {
        return $this->user->select('id', 'name')->get();
    }
    public function create(array $data)
    {
        return $this->user->create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
    public function assignRole($user, $roleName)
    {
        $user->assignRole($roleName);
    }
}
