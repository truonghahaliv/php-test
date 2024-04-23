<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserInterface
{
    protected User  $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function paginate($perPage = 5)
    {
        return $this->user->paginate($perPage);
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
}
