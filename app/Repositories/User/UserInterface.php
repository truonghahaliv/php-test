<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserInterface
{
    public function all();
    public function create(array $data);
    public function update(User $user, array $data);
    public function delete(User $user);
}
