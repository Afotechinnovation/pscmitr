<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function viewAny(Admin $Admin)
    {
        if($Admin->can('roles.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Question $role
     * @return mixed
     */
    public function view(Admin $Admin, Role $role)
    {
        if($Admin->can('roles.view'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can create models.
     *
     * @param  \App\Models\Admin  $Admin
     * @return mixed
     */
    public function create(Admin $Admin)
    {
        if($Admin->can('roles.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Role $role
     * @return mixed
     */
    public function update(Admin $Admin, Role $role)
    {
        if($Admin->can('roles.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Role $role
     * @return mixed
     */
    public function delete(Admin $Admin, Role $role)
    {
        if($Admin->can('roles.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Question $question
     * @return mixed
     */
    public function restore(Admin $Admin, Role $role)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\Role $role
     * @return mixed
     */
    public function forceDelete(Admin $Admin, Role $role)
    {
        //
    }
}
