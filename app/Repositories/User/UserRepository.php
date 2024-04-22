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

    public function all()
    {
        return $this->user
            ->get();
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
