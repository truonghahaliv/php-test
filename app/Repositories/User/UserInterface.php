<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserInterface
{
    public function paginate($perPage = 5);
    public function create(array $data);
    public function update(User $user, array $data);
    public function delete(User $user);
}
