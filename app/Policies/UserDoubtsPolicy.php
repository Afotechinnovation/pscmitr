<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\UserDoubt;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserDoubtsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the Admin can view any models.
     *
     * @param  \App\Models\Admin  $Admin
     * @return mixed
     */
    public function viewAny(Admin $Admin)
    {
        if($Admin->can('doubts.viewAny'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\UserDoubt $userDoubts
     * @return mixed
     */
    public function view(Admin $Admin, UserDoubt $userDoubts)
    {
        if($Admin->can('doubts.view'))
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
        if($Admin->can('doubts.create'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\UserDoubt $userDoubts
     * @return mixed
     */
    public function update(Admin $Admin, UserDoubt $userDoubts)
    {
        if($Admin->can('doubts.update'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\UserDoubt $userDoubts
     * @return mixed
     */
    public function delete(Admin $Admin, UserDoubt $userDoubts)
    {
        if($Admin->can('doubts.destroy'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\UserDoubt $userDoubts
     * @return mixed
     */
    public function restore(Admin $Admin, UserDoubt $userDoubts)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $Admin
     * @param  \App\Models\UserDoubt $userDoubts
     * @return mixed
     */
    public function forceDelete(Admin $Admin, UserDoubt $userDoubts)
    {
        //
    }
}
