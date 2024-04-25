<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $roles = Role::with('permissions')->get();
        $permissionsArray = [];
        foreach ($roles as $role) {
            foreach ($role->permissions as $permissions) {
                $permissionsArray[$permissions->name][] = $role->id;
            }
        }

// Every permission may have multiple roles assigned
        foreach ($permissionsArray as $name => $roles) {
            Gate::define($name, function ($user) use ($roles) {
                // We check if we have the needed roles among current user's roles
                return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
            });
        }
    }
}
